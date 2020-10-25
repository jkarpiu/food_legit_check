import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)

db = mydb.cursor()
db.execute("CREATE TABLE dodomku (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), image VARCHAR(255), barcode VARCHAR(255), components VARCHAR(255), price VARCHAR(255))")

# sql = "INSERT INTO products (name, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s)"
# val = ('Krokiet 300g', 'http://www.eskleplewiatan.pl/zdjecia/6716_2.jpg', '5902596648145', 'masło, śliwki', '2.46')
# db.execute(sql, val)

# mydb.commit()

# print(db.rowcount, "record inserted.")