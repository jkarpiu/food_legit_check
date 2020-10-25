import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)

mycursor = mydb.cursor()

sql = "UPDATE products SET components = NULL WHERE components = ''"

mycursor.execute(sql)

mydb.commit()

print(mycursor.rowcount, "record(s) affected")