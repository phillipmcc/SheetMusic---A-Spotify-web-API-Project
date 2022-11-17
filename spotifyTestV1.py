import requests
import json

# NOTE: if the program doesn't run it's likely cos of the filters, i know two genres that work are, hip-hop and indie. it's just cos it needs to be the same as what spotify calls it's genres, i.e. spotify has no rap genre but it does have a hip-hop genre

# EXAMPLE TOKEN: BQD1dUPA7i10zihoA8zuMriVbbYgdJK1SpRVarWIgjrjtsHbe6L_VFYib_A6cLF4z4nZMG6A851bzvir31z1OHG-m8YSBemKj6qAGtDPjBHrY8JpOff3SbIdG0ts1ziKe6z0U3dO3bzcxwS22GMeVNkpQrI1DgN3GPESAZJHXCq3DYVhvNKAxm2Q

# SETTINGS 
endpoint_url = "https://api.spotify.com/v1/recommendations?"

# to get a token go to https://developer.spotify.com/console/get-recommendations/ and scroll to the bottom, click get token, tick the box that says "playlist-modify-private" then you can generate a token, copy and paste it below. 
# the token should look like the random string above

token = "put generated token here"


user_id = "your spotify username here"

# FILTERS
limit=10
market="US"
seed_genres="hip-hop"
target_danceability=0.5
uris = [] 

# to change the seeds you go to spotify, right click on the artist you want as the guide for the generation, click share and then copy link.
# you'll get a link like this: https://open.spotify.com/artist/3nFkdlSjzX9mRTtwJOzDYB?si=8ed1c6889c564d7b and you need this bit https://open.spotify.com/artist/thisValueHere?si=8ed1c6889c564d7b
# then you do the same for a track of you're choice

seed_artists = '2YZyLoL8N0Wb9xBt1NhZWg'
seed_tracks = '0UtnpKaReKUg2GquaSxCyD'


# PERFORM THE QUERY
query = f'{endpoint_url}limit={limit}&market={market}&seed_genres={seed_genres}&target_danceability={target_danceability}'
query += f'&seed_artists={seed_artists}'
query += f'&seed_tracks={seed_tracks}'

response = requests.get(query, 
               headers={"Content-Type":"application/json", 
                        "Authorization":f"Bearer {token}"})
json_response = response.json()

print('Recommended Songs:')
for i,j in enumerate(json_response['tracks']):
            uris.append(j['uri'])
            print(f"{i+1}) \"{j['name']}\" by {j['artists'][0]['name']}")


# CREATE A NEW PLAYLIST


endpoint_url = f"https://api.spotify.com/v1/users/{user_id}/playlists"

request_body = json.dumps({
          "name": "Generated Playlist Name Here",
          "description": "Generated Description Here",
          "public": False
        })
response = requests.post(url = endpoint_url, data = request_body, headers={"Content-Type":"application/json", 
                        "Authorization":f"Bearer {token}"})

url = response.json()['external_urls']['spotify']
print(response.status_code)

# FILL THE NEW PLAYLIST WITH THE RECOMMENDATIONS

playlist_id = response.json()['id']

endpoint_url = f"https://api.spotify.com/v1/playlists/{playlist_id}/tracks"

playlist_link = f"https://open.spotify.com/playlist/{playlist_id}"
print(playlist_link)

request_body = json.dumps({
          "uris" : uris
        })
response = requests.post(url = endpoint_url, data = request_body, headers={"Content-Type":"application/json", 
                        "Authorization":f"Bearer {token}"})

print(response.status_code)

