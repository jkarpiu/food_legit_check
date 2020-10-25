import mysql.connector
import io
import json

with io.open('duplicates.txt', "w", encoding="utf-8") as file:
    file.write('')

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)

db = mydb.cursor()

sql = "INSERT INTO products (name, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s)"

db.execute("SELECT * FROM dodomku")
products = db.fetchall()
for product in products:
    val = (product[1], product[2], product[3], product[4], product[5])
    try:
        db.execute(sql, val)
        mydb.commit()
    except mysql.connector.IntegrityError:
        print('Produkt nie zostal dodany - produkt juz istnieje w bazie!')
        with io.open('duplicates.txt', "a", encoding="utf-8") as file:
            file.write(json.dumps(product))
            file.write('\n')
        pass