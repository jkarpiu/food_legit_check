import io
import time
import mysql.connector
from selenium import webdriver

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)


db = mydb.cursor()
sql = "INSERT INTO products (name, category, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s, %s)"
url = 'http://www.google.com'
driver = webdriver.Firefox()
with driver as driver:
    def newCategory(url):      
        arrayofLinks = []
        number_of_lines = len(open('NotAddedProducts.txt').readlines())
        with io.open('NotAddedProducts.txt', "r") as file:
            arrayofLinks = file.readlines()
        for link in arrayofLinks:
            number_of_lines -= 1
            driver.get(link)
            skladniki = 'null'
            kategoria = 'Słodycze'
            zdjecie = 'null'
            nazwa = 'null'
            kod_kreskowy = 'null'
            # time.sleep(1)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines, 'produktow')
            try:
                zdjecie = driver.find_element_by_css_selector('.main-photo img').get_attribute('src')
            except Exception:
                    try:
                        zdjecie = driver.find_element_by_css_selector('#karta_galeria a img').get_attribute('src')
                    except Exception:
                        print('Nie znaleziono zadnego zdjecia')
                        with io.open('failed.txt', "a") as file:
                            file.write(link)
                        continue
            try:
                nazwa = driver.find_element_by_css_selector('h1.title').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('.meta-info div:nth-child(3)').get_attribute('textContent').replace('Kod kreskowy:', '')
                cena = driver.find_element_by_css_selector('.cena .price .wartosc.nobr')
                pola_opisu = driver.find_elements_by_css_selector('.desc-col *')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed.txt', "a") as file:
                    file.write(link)
                continue
            cena = cena.get_attribute('textContent').replace(' zł', '')
            isFound = False
            skladniki = ''
            for pole in pola_opisu:
                if isFound == True:
                    if (pole.get_attribute('class') == 'text'):
                        skladniki = pole.get_attribute('textContent')
                        break
                if (pole.get_attribute('textContent') == 'Składniki'):
                    isFound = True
                if (skladniki == ''):
                    skladniki = 'null'
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            val = (nazwa, kategoria, zdjecie, kod_kreskowy, skladniki , cena)
            try:
                db.execute(sql, val)
            except mysql.connector.IntegrityError:
                print('Rekord istnieje w bazie')
                pass
            mydb.commit()
        driver.quit()
    newCategory(url)
