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
		sql = """
				SELECT tags.tagName, tags.tagID, users.id FROM userTagsRel 
				INNER JOIN users ON users.id=userTagsRel.userID 
				INNER JOIN tags ON tags.tagID=userTagsRel.tagID 
				WHERE users.updated_at IS NOT NULL OR users.updated_at IS NULL
				ORDER BY tags.tagName ASC""";
		cursor.execute(sql)

		items = cursor.fetchall()
		tagid = []

		summary_sql = 'INSERT IGNORE INTO newsSummary (sourceLinkID, userID, tagID, points) VALUES (%s, %s, %s, %s)'
		for item in items:
			if item['tagID'] not in tagid:
				tagid = []
				tagid.append(item['tagID']);

				ids = self.processRanks(cursor, item['tagName']) # Create rows based on these ids + point value


			for id_item in ids:
				cursor.execute(summary_sql, (id_item['sourceLinkID'], item['id'], item['tagID'], id_item['rank']))
 
	def processRanks(self, cursor, word):
		rank = ''
		ids = []
		it_titles = self.returnIds(cursor, 'SELECT sourceLinkID FROM sourceLinks WHERE sourceDate >= DATE_SUB(NOW(), INTERVAL 24 HOUR) AND active = 1 AND sourceTitle LIKE %s', word, '0')
		it_raws = self.returnIds(cursor, 'SELECT sourceLinkID FROM sourceLinks WHERE sourceDate >= DATE_SUB(NOW(), INTERVAL 24 HOUR) AND active = 1 AND sourceRaw LIKE %s', word, '1')


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

	def returnIds(self, cursor, query, word, searchtype):
		ids = []
		if searchtype == '0':
			cursor.execute(query, ('%' + word + '%'))
		else:
			cursor.execute(query, ('% ' + word + ' %'))


		items = cursor.fetchall()
		for item in items:
			ids.append(item['sourceLinkID'])
			
		return ids
	def clearRank(self, cursor):
		sql = 'TRUNCATE newsSummary'
		cursor.execute(sql)


User()
'''

SELECT tags.tagName, tags.tagID, users.id FROM userTagsRel 
INNER JOIN users ON users.id=userTagsRel.userID 
INNER JOIN tags ON tags.tagID=userTagsRel.tagID 
WHERE users.updated_at IS NOT NULL
ORDER BY tags.tagName ASC;

news_summary
aggnewsID
sourceLinkID
userID
tagID
points


Title matches should rank higher (REGEX) 3 pt
Content matches should rank lower (REGEX) 1 pt

Get ID of accounts that are active (15 days or less)
	Loop through Tags of a User
		Search matches for title
		UPDATE tag
	CLEAR CURRENT RANKING IF SUCCESFUL
'''