# I found a Facebook pshishing site, so I decided to flood their database with junk.
import requests

url = 'SCAMMER URL'

i = 1
b = 1
while i < 2:
    # Payload data, change this to the post values accepted by the phishing site
    email = "yourfaketext" + str(b)  + "@gmail.com"
    password = "Dumb Scammer"
  
    payload = {"email":email,"password":password,"birthday_day":"1","birthday_month":"2","birthday_year":"1969"}
    b = b + 1
    r = requests.post(url, data=payload)

    # change keyword to something you should see on success
    if "keyword" in r.text:
        print(email)
    else:
        i = 2
        print("end")
