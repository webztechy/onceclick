# onceclick
Task assigned - API

# Dabatabse
Please download the database copy inside the database folder
* You can change the database detail in this directory
	-> onceclick->config->database.php

# User Credentials
username = admin
password = admin

username = cashier
password = cashier

Authenticatiion
http://localhost/oneclick/login?username=cashier&password=cashier
- checking if fields are present
- Checking url if its intended for admin or cashier user


# Products
http://localhost/oneclick/admin/products/all
- Only Admin can access

http://localhost/oneclick/admin/products/add?barcode=1235&name=nescafe&cost=12.50&vat=6
- checking if fields are present
- checking vat either 6% or 21%
- Only Admin can access


# Receipts
http://localhost/oneclick/cashier/receipts/add?code=123
- checking if fields are present
- changing receipt status = 0 (default)
- Only Cashier can access

http://localhost/oneclick/cashier/receipts/add-product?code=123&barcode=1234
- checking if fields are present
- checking receipt code id exist
- checking product barcode id exist
- Only Cashier can access

http://localhost/oneclick/cashier/receipts/price-product-last/?code=123&price=3
- checking if fields are present
- checking receipt code id exist
- Only Cashier can access

http://localhost/oneclick/cashier/receipts/finish?code=123
- checking if fields are present
- checking receipt code id exist
- changing receipt status = 1
- Only Cashier can access

http://localhost/oneclick/receipts/detail?code=123
- checking if fields are present
- checking receipt code id exist
- Only Cashier can access


# Other Extra
- Admin: add discounts, e.g. for all new receipts, with 3 or more of product A, the 3rd is for free, show this discount on receipts
http://localhost/oneclick/receipts/add-discount?code=125&discount=2
- checking if fields are present
Added Info
* discounted_items
* discounted_total


- Admin: remove a product/row from a receipt that is not finished yet
http://localhost/oneclick/receipts/remove-product?code=125&row=2
- checking if fields are present

- Add some automated test (extreme TDD is not necessary)
- Create a pdf from finished receipt using any library you want
http://localhost/oneclick/receipts/pdf?code=125
* It will printout the PDF receipt else jcon detail.


