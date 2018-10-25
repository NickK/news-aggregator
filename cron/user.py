#!/usr/bin/python3
import pymysql.cursors
import os
from dotenv import load_dotenv

#load env file
dotenv_path = '../.env'
load_dotenv(dotenv_path)

class User:

	MYSQL_HOST = os.environ.get("DB_HOST")
	MYSQL_USER = os.environ.get("DB_USERNAME")
	MYSQL_PASSWORD = os.environ.get("DB_PASSWORD")
	MYSQL_DATABASE = os.environ.get("DB_DATABASE")
	MYSQL_CHARSET = 'utf8'

	PT_TITLE = 3;
	PT_RAW = 1;

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
    			self.clearRank(cursor)
		    	self.fetchUserTags(cursor)
		    	connection.commit()
		finally:
			connection.close()


	def fetchUserTags(self, cursor):
		links = []
		summary_sql = 'INSERT IGNORE INTO newsSummary (sourceLinkID, userID, tagID, points) VALUES (%s, %s, %s, %s)'

		sql = """
				SELECT users.id, tags.tagID, tags.tagName FROM users 
				LEFT JOIN userTagsRel ON userTagsRel.userID=users.id 
				INNER JOIN tags ON userTagsRel.tagID=tags.tagID 
				WHERE users.updated_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
				ORDER BY users.id ASC"""

		cursor.execute(sql)
		userTags = cursor.fetchall()
		for tag in userTags:
			# Fetch Users Sources
			srcIds = self.returnSourceIds(cursor, 'SELECT sourceID FROM userSourcesRel WHERE userID = %s', tag['id'])

			# Fetch and rank article importance
			#sourceIDs.append(tag['tagName'])
			articles = self.processRanking(cursor, tag['tagName'], srcIds)

			#Prepare all links
			for article in articles:
				links.append([article['sourceLinkID'], tag['id'], tag['tagID'], article['rank']])

		cursor.executemany(summary_sql, links)
 
	def processRanking(self, cursor, word, srcIds):
		rank = ''
		src_query = ''
		ids = []

		#Prepare query strings
		for i in srcIds:
			src_query += '%s,'

		values = self.processRankSearchValues(srcIds.copy(),srcIds.copy(),word)

		it_titles = self.returnLinkIds(cursor, 'SELECT sourceLinkID FROM sourceLinks WHERE sourceDate >= DATE_SUB(NOW(), INTERVAL 30 HOUR) AND active = 1 AND sourceID IN(' + src_query[:-1] + ') AND sourceTitle LIKE %s', values[0])
		it_raws = self.returnLinkIds(cursor, 'SELECT sourceLinkID FROM sourceLinks WHERE sourceDate >= DATE_SUB(NOW(), INTERVAL 30 HOUR) AND active = 1 AND sourceID IN(' + src_query[:-1] + ') AND sourceRaw LIKE %s', values[1])


		for item in it_titles:
			number = self.PT_TITLE

			if item in it_raws:
				number = number + self.PT_RAW

			ids.append({'sourceLinkID': item, 'rank': number})

		for item in it_raws:
			number = self.PT_RAW

			if item not in it_titles:
				ids.append({'sourceLinkID': item, 'rank': number})

		return ids

	def processRankSearchValues(self,q_title_val, q_raw_val, word):
		q_title_val.append('%' + word + '%')
		q_raw_val.append('% ' + word + ' %')

		return [q_title_val,q_raw_val]

	def returnSourceIds(self, cursor, query, id):
		ids = []
		cursor.execute(query, (id))

		items = cursor.fetchall()
		for item in items:
			ids.append(item['sourceID'])

		return ids

	def returnLinkIds(self, cursor, query, array):
		ids = []
		
		cursor.execute(query, (array))
		items = cursor.fetchall()
		for item in items:
			ids.append(item['sourceLinkID'])
			
		return ids
	def clearRank(self, cursor):
		sql = 'TRUNCATE newsSummary'
		cursor.execute(sql)


User()