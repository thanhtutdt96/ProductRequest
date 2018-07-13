<img src="https://www.magento.com/sites/all/themes/magento/logo.svg" width="200">

# Product Request Module - Magento 1.9


This module helps simplify the interaction between visitors, customers and website admins/managers. Customers can easily send their requests or wishes about a new product to the website admin. 
These requests will be directly saved to magento database, where the admins can easily access, verify, modify or approve them. Each time a request is submitted by customer, or approved by the admin,
an email notification will be automatically sent to the customer inbox.
## Getting Started

### Prerequisites
**modman**

With modman, you can specify in a text file where you want your directories and files to be mapped to, and it will maintain symlinks for you so that your code is easy to hack and deploy.

Reference link: [modman (Module Manager)](https://github.com/colinmollenhour/modman)
```
bash < <(curl -s -L https://raw.github.com/colinmollenhour/modman/master/modman-installer)
```
Installing modman globally:
```
mv ~/bin/modman /usr/local/{{ preferred folder }}
```

**Magento SMTP Pro Extension**
An extension for magento which help you easily send Magento transactional emails via Google Apps, Gmail, Amazon SES or your own SMTP server. 

We will need this extension in order to send notification
email to customers using SMTP mailbox, which isn't supported by default by magento. 

Reference link: [modman (Module Manager)](https://github.com/colinmollenhour/modman)


### Installing

To install the Product Request module, first, you have to download and extract it to .modman folder in magento source, or just simply clone the module by running this script:

```
git clone -b tu_dev --single-branch git@gitlab.framltd.se:phong.phan/Product-Request.git
```

After successfully cloning the Product-Request module, proceed to install the module into magento using following command:

```
moman deploy Product-Request --force
```


## Running the module

### Access the front-end form

This is the place where customers or visitors will input information including their name, email, image, comment about the product which they want to request.
The front-end form can be accessed via the following link: 
```
/productrequest/index/index
```
<img src="https://i.imgur.com/oFgB8vw.png" width="300">

### Manage requests with admin grid

All the requests which submitted by the customers will be here. The administrator will be responsible for checking the validations of each request and approve if it is verified. 
The administrator can also approve multiple requests at a sametime, disapprove or delete them.

<img src="https://i.imgur.com/pxynyzR.png" width="800">

## Built With

* [Magento](https://www.magento.com/) - The main framework used

## Versioning

Module Version 0.0.1
## Authors

* **Tu Pham** - *Associate Software Engineer* at fram^
* Follow me on [GitHub](https://github.com/thanhtutdt96)
