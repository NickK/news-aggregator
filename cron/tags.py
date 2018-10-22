import pymysql.cursors
from bs4 import BeautifulSoup
import os
from dotenv import load_dotenv
import nltk
from nltk.tokenize import PunktSentenceTokenizer
from bs4 import BeautifulSoup

#load env file
dotenv_path = '../.env'
load_dotenv(dotenv_path)

class Tags:

	MYSQL_HOST = os.environ.get("DB_HOST")
	MYSQL_USER = os.environ.get("DB_USERNAME")
	MYSQL_PASSWORD = os.environ.get("DB_PASSWORD")
	MYSQL_DATABASE = os.environ.get("DB_DATABASE")
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
		    	self.fetchLinks(cursor)
		    	connection.commit()
		finally:
			connection.close()

	def fetchLinks(self, cursor):
		print('fetchLinks')

		train_text = self.fetchAllRaw(cursor)

		sql = 'SELECT sourceID, sourceLink, sourceLinks.sourceTitle, sourceLinks.sourceRaw FROM sourceLinks WHERE active = 1 LIMIT 1'
		cursor.execute(sql)

		items = cursor.fetchall()
		#print(items)
		for item in items:
			#print(item['sourceID'])
			print(item['sourceLink'])

			soup = BeautifulSoup(item['sourceTitle'], 'html.parser')
			text = soup.get_text()

			custom_sent_tokenizer = PunktSentenceTokenizer(train_text)
			tokenized = custom_sent_tokenizer.tokenize(text)

			print(tokenized);

			try:
				for i in tokenized:
					words = nltk.word_tokenize(i)
					tagged = nltk.pos_tag(words)

					chunkGram = r"""Chunk: {<NN.?>+<NN.?>*}"""

					chunkParser = nltk.RegexpParser(chunkGram)

					chunked = chunkParser.parse(tagged)

					print(chunked)
					#links = []

					# for tag in tagged:
					# 	if 'NNS' in tag:
					# 		print(tag[0])
					# 		insert_sql =  "INSERT IGNORE INTO tags (tagName) VALUES (%s)"
					# 		cursor.execute(insert_sql, tag[0])


					#Need to associate each tag with each sourceLink articles

			except Exception as e:
				print(str(e))

	def fetchAllRaw(self, cursor):
		print('fetchAllRaw')
		sql = 'SELECT sourceLinks.sourceRaw FROM sourceLinks WHERE active = 1'
		cursor.execute(sql)

		string = ''
		items = cursor.fetchall()
		for item in items:
			#print(item)
			soup = BeautifulSoup(item['sourceRaw'], 'html.parser')
			string += soup.get_text()


		return string
		'''
			Loop through active articles
				Strip HTML
					Convert to Tags by breaking down using NLTK
							Save words to Tags table, add relationship to sourceTags table (needs tagID)
		'''


tags = Tags()