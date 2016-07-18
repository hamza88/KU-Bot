from nltk.tag import pos_tag
import demjson

class NLP:
	@staticmethod
	def extractNouns(text):
		taggedWords = pos_tag(text.split())
		l = [word for word,pos in taggedWords if pos == 'NN']
		outRes = dict((str(i), l[i]) for i in range(0,len(l)))
		if bool(outRes):
			print demjson.encode(outRes)
		else:
			return False
