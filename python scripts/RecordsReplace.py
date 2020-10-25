import mysql.connector
import time

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)
### Price
db = mydb.cursor()
db.execute("SELECT id, price FROM products")
sql = "UPDATE products SET price = %s WHERE id = %s"
records = db.fetchall()
for x in records:
    if ',' in x[1]:
        cena = x[1].replace(',', '.')
        val = (cena, x[0])
        db.execute(sql, val)
        mydb.commit()


