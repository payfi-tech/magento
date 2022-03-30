"# magento2 payfi plugin" 

1.Upload the files to app/code

2.Change public key in the file below to client public key
 Payfi\Payments\view\frontend\web\js\view\payment\method-renderer\payfipayment.js
 
3. Run php bin/magento setup:upgrade

4. php bin/magento setup:static-content:deploy
