import argparse
import scraper

parser = argparse.ArgumentParser()
parser.add_argument('--key',help='File which contains the key in plaintext. Should only contain the key.')
args = parser.parse_args()

keyfile = open(args.key)
api_key = keyfile.readline()
keyfile.close()
header = {'Accept': 'application/json', 'user-key':api_key}

citiesToScan = ['Portland']
for city in citiesToScan:
	rests = scraper.Scraper(header,city)
	print(str(rests))
	rests.writeJSON(city+'.json')

	#INSERT INTO DB HERE if wanted.
	for restaurant in rests.restaurants:
		print(restaurant['rname'])
		print(restaurant['address'])
		print(str(restaurant['cname']))
		print(restaurant['roverall'])