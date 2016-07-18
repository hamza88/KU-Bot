import aiml

class Chat:
	@staticmethod
	def Ask(question):
		# Create the kernel and learn AIML files
		kernel = aiml.Kernel()
		kernel.verbose(False)
		kernel.learn("python/bot/std-startup.xml")
		kernel.respond("load aiml b")
		print kernel.respond(question)
