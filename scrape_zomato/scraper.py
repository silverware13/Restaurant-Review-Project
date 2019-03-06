import requests
import json
import argparse

class Scraper:
	def __init__(self,header,city):
		self.city = city
		self.header = header
		self.increment = 20 #Zomato default
		self.restaurants = [] #list of restaurant dictionaries 
		# Each dictionary has the restaurant's name, address, cuisines (list), and its aggregate rating
		self.scrape()

	def getCityId(self):
		print("Getting City ID of {}".format(self.city))
		cities=requests.get(url='https://developers.zomato.com/api/v2.1/locations?query={}'.format(self.city),headers=self.header).json()
		if(not len(cities['location_suggestions']) == 1):
			return False #If there is more than 1 city found return an error.
		self.cityid = cities['location_suggestions'][0]['entity_id']
		return True

	# Make repeating calls to the api with offsets of self.increment. This value is a limit placed on the API itself.
	def loopCity(self):
		current=0
		while(current < self.total):
			print('Getting restauraunts in city {city}... {cur}/{total}'.format(city=self.city,cur=current,total=self.total),end='\r')
			appendurl = '&start={}&count={}'.format(current,self.increment) #Zomato API limits to 20 results per call.
			restList = requests.get(self.baseurl+appendurl,headers=self.header).json()
			for restaurant in restList['restaurants']:
				r=restaurant['restaurant']
				rest = {}
				rest['rname'] = r['name']
				rest['address'] = r['location']['address']
				rest['cname'] = r['cuisines'].split(', ')
				rest['roverall'] = float(r['user_rating']['aggregate_rating'])
				self.restaurants.append(rest)
			current+=20
		print()

	def scrape(self):
		if(not self.getCityId()):
			return False
		print("Getting restaurants in city {}".format(self.city),end='\r')
		self.baseurl='https://developers.zomato.com/api/v2.1/search?entity_id={}&entity_type=city'.format(self.cityid)
		info = requests.get(self.baseurl,headers=self.header).json()
		self.total = info['results_found']
		self.loopCity()

	# When you call cast this as a string, e.g. str(scraper)
	def __str__(self):
		s = ''
		for rest in self.restaurants:
			for attr in rest:
				s+="{key}: {val}\n".format(key=attr,val=rest[attr])
			s+='\n'

	# Writes to a JSON file
	def writeJSON(self,destfile):
		result = {}
		result['city'] = self.city
		result['restaurants'] = self.restaurants
		f = open(destfile,'w')
		f.write(json.dumps(result))
		f.close()