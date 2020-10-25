import mysql.connector
import io
import json

mydb = mysql.connector.connect(
  host="localhost",
  user="user",
  password="user",
  database="food_legit_check"
)

with io.open('chorobska.json', "r") as file:
    choroby = json.loads(file.read())

db = mydb.cursor()

db.execute("SELECT id, components FROM products")
produkty = db.fetchall()

sql = "UPDATE products SET illness = %s WHERE id = %s"

for p in produkty:
    ills = ''
    if (p[1] != None):
        for ch in choroby:
            for title in ch['titles']:
                if (title in p[1]):
                    ills += str(ch['id']) + ','
        ills = ills[:-1]
        val = (ills, p[0])
        db.execute(sql, val)
        mydb.commit()
    
                    





