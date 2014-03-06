nearbySearch
============

Example of how to retrieve information from the Google Places API. 
This requires to have installed php5-curl and php5-json.

In order to retrieve information it's necessary to define the API_KEY on the settings.ini file. 

There are two searches provided: 

	1) Text Search 
	2) Nearby search

1) Text Search: returns information (name, address) about locations based on a string. Usage:

http://localhost/nearbySearch/nearby.php?query=clubs+in+Berlin&type=text

or

http://localhost/nearbySearch/nearby.php?query=best+doener+Berlin

Please note that the type parameter is optional. This is the default search.


2) Nearby Search: returns information (name, address) of places within an specified location. 

http://localhost/nearbySearch/nearby.php?query=steakhouse&radius=5000&type=nearby

or

http://localhost/nearbySearch/nearby.php?query=museum&type=nearby

or 

http://localhost/nearbySearch/nearby.php?query=hotel&type=nearby&radius=2000&location=50.121212,8.6365638

query and type=nearby are required. 
location is optional and must be latitude,longitude. In case it's not defined the value of Berlin will be used.
radius is optional and it's expressed in meters. Default value 500m 











