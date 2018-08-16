import pymysql.cursors
from bs4 import BeautifulSoup
import requests
import os


class Crawler:

	MYSQL_HOST = 'mysql'
	MYSQL_USER = 'root'
	MYSQL_PASSWORD = 'root'
	MYSQL_DATABASE = 'database'
	MYSQL_CHARSET = 'utf8'

	def __init__(self):

		# Connect to the database
		connection = pymysql.connect(host=self.MYSQL_HOST,
		                             user=self.MYSQL_USER,
		                             password=self.MYSQL_PASSWORD,
		                             db=self.MYSQL_DATABASE,
		                             charset=self.MYSQL_CHARSET,
		                             cursorclass=pymysql.cursors.DictCursor)

		try:
		    with connection.cursor() as cursor:
		    	self.collectLinks(cursor)
		    	connection.commit()
		    	
		    	self.crawlThroughLinks(cursor)
		    	connection.commit()
		finally:
			connection.close()

	def collectLinks(self, cursor):
		# Fetch Sources from DB
		sql = 'SELECT sourceID, domain, sourceMainURL, aggregator FROM sources';
		cursor.execute(sql)
		items = cursor.fetchall()
		for item in items:
			insert_sql = ''
			links = []

			# fetch and parse using BeautifulSoup
			content = self.fetchAndParseWebsite(item['sourceMainURL'])
			for anchor in content.find_all('a'):
				link_label = anchor.text.encode('utf-8').decode('ascii', 'ignore').strip()
				link_url = anchor.get('href', '/')

				sourceTitle = ''
				if item['aggregator'] is 1:
					sourceTitle = anchor.text.encode('utf-8').decode('ascii', 'ignore').strip()

				# Remove links where the label is less than 30 characters (Articles usally have longer labels), exclude things like <img, <source, #comments, /users/
				if len(link_label) > 30 and '<img' not in link_label and '<source' not in link_label  and "#comments" not in link_url and "/users/" not in link_url: 
					#Prepare list item
					links.append([item['sourceID'], self.convertToAbsoluteURL(item['aggregator'], item['domain'],anchor.get('href', '/')), sourceTitle])
					insert_sql =  "INSERT IGNORE INTO sourceLinks (sourceID, sourceLink, sourceTitle, created_at, updated_at) VALUES (%s, %s, %s, now(), now())"
					
			cursor.executemany(insert_sql, links)


	def crawlThroughLinks(self, cursor):
		#crawl through links and collect website articles
		
		sql = 'SELECT sourceLinks.sourceLinksID, sourceLinks.sourceLink, sources.aggregator FROM sourceLinks INNER JOIN sources ON sourceLinks.sourceID=sources.sourceID';
		cursor.execute(sql)
		items = cursor.fetchall()
		for item in items:
			content = self.fetchAndParseWebsite(item['sourceLink'])

			print(item['sourceLink'])

			success = 0
			dump = ''

			if content.select('article h1, article h2'):
				success = 1
				dump = self.getContent(content, 'article', 'article p')

			elif content.select('meta[property="author"],meta[property="article:published_time"],meta[content="article"]'):
				success = 1
				dump = self.getContent(content, '', 'p')
			else:
				print('deactivate sourceLink')


			if success is 1:
				if item['aggregator'] is 1:
					update = 'UPDATE sourceLinks SET sourceArticle = %s WHERE sourceLinksID = %s'
					cursor.execute(update, (dump[1], item['sourceLinksID']))
				else:
					update = 'UPDATE sourceLinks SET sourceTitle = %s, sourceArticle = %s WHERE sourceLinksID = %s'
					cursor.execute(update, (dump[0], dump[1], item['sourceLinksID']))
					

	def getContent(self, content, title, paragraph):
		title = content_dump = ''
		if content.select(title + ' h1'):
			for item_h1 in content.select(title + ' h1'):
				title = item_h1.text.encode('utf-8').decode('ascii', 'ignore')
		elif content.select(title + ' h2'):
			for item_h2 in content.select(title + ' h2'):
				title = item_h2.text.encode('utf-8').decode('ascii', 'ignore')

		for item_p in content.select(paragraph):
			print(item_p.encode('utf-8').decode('ascii', 'ignore'))
			content_dump += item_p.encode('utf-8').decode('ascii', 'ignore')

		return [title, content_dump]
		
		#print('test')
	def fetchAndParseWebsite(self, link_url):
		headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'}
		story = requests.get(url=link_url, headers=headers)
		print(story)
		return BeautifulSoup(story.content, 'html.parser')
	def convertToAbsoluteURL(self, aggregator, domain, link):
		# Some websites use relative URLs not absolute URLS
		if domain not in link and aggregator is 0 and 'https' not in link and 'http' not in link:
			return 'http://' + domain + link
		return link


crawler = Crawler()

'''
Add the titles from user submitted content for agg website
Content select(h1) etc need their own classes



THEORY:

Global pages:
Only save links with labels

Individual pages
Script looks for <article> element that have an h1 inside of them
if true
	Save everything inside article
--
if page has author meta
else if true:
	Save the whole page or at least closest to the content possible
--
else:
	Delete page from sourceLinks

'''