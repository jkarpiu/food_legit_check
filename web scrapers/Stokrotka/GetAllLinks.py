import io
import json
import time
from selenium import webdriver

with io.open('links.txt', "w") as file:
    file.write('')
driver = webdriver.Firefox()
with driver as driver:
    for i in range(1, 19):
        driver.get('https://sklep.stokrotka.pl/art-spozywcze'+'/strona-'+str(i)+'/?pp=100')
        products = driver.find_elements_by_css_selector(".product .photo a")
        arrayofLinks = []
        for product in products:
            with io.open('links.txt', "a") as file:
                file.write(product.get_attribute('href') + '\n')
    driver.quit()
