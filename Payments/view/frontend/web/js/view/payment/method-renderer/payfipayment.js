define(
  [
    'Magento_Checkout/js/view/payment/default',
    'Magento_Checkout/js/model/quote'
  ],
  function (Component, quote) {
    'use strict';

    return Component.extend({
      config: window.checkoutConfig,

      defaults: {
        template: 'Payfi_Payments/payment/payfipayment'
      },
      getCustomerEmail: function () {
        return quote.guestEmail || this.config.customerData.email;
      },

      getQuoteAmount: function () {
      
      return Math.ceil(quote.totals().grand_total);
        //return this.config.quoteData.grand_total;
      },

      getQuoteCurrency: function () {
        return this.config.quoteData.quote_currency_code;

      },

      quoteRef: function () {
        return  quote.getQuoteId() + '_' + new Date().valueOf();

      },

      getPayfiConfigValue: function (key) {
        return this.config.payment.payfi[key] || '';
      },

      callback: function (res) {
        this.processPaymentResponse(res);
      },

      /** Returns send check to info */
      buildConfig: function () {
        var payfi_country;
       
        
        return {
          amount: this.getQuoteAmount(),
          currency: this.getQuoteCurrency(),
          country: payfi_country,
          custom_description: this.getPayfiConfigValue('modal_desc'),
          custom_logo: this.getPayfiConfigValue('logo'),
          custom_title: this.getPayfiConfigValue('modal_title'),
          customer_email: this.getCustomerEmail(),
          PBFPubKey: this.getPayfiConfigValue('pb_key'),
          LivePubKey: this.getPayfiConfigValue('live_pb_key'),
          txref:  this.quoteRef(),
          callback: this.callback.bind(this)
        };
      },

      /** Place Order action */
      makePayment: function () {
        var test = this.getPayfiConfigValue('test_mode');
        test = (parseInt(test) == 1) ? true : false;
         var _this = this;
          
         let amount= _this.buildConfig().amount;
         let ref= _this.buildConfig().txref;
         console.log("REF "+ref)
         console.log("AMOUNT "+amount)
        
        if (test) {

           
          let disabled = false
         
          
          const payfi = new Payfi(
            {
              //apiKey: _this.buildConfig().LivePubKey,
                apiKey: 'pk_4435cecb-96b3-495e-bcc9-69257b1dce5b',
                          callback: reference => {
                 //document.getElementById("btn").removeAttribute("disabled");
                  console.log('callback called', reference);

              },
              onClose: () => {
                console.log('modal close');
                this.placeOrder();

              
              }
            }
          );

          console.log(payfi);
          setTimeout(() =>{
          
            
        
         payfi.pay({ amount:amount, reference:ref })

         },100)
           
             

        } else {  

         
          
     
          let disabled = false
        

          const payfi = new Payfi(
            {
                //apiKey: _this.buildConfig().LivePubKey,
                apiKey: 'pk_4435cecb-96b3-495e-bcc9-69257b1dce5b',
              callback: reference => {
                  //document.getElementById("btn").removeAttribute("disabled");
                  console.log('callback called', reference);
                 
              },
              onClose: () => {
                this.placeOrder();
              }
            }
          );
          console.log("Live")
            console.log(payfi);

          setTimeout(() =>{
                 payfi.pay({ amount:amount, reference:ref })


         },100);



        }
      },

      setErrorMessage: function (message) {
        this.messageContainer.addErrorMessage({
          message: 'Payment could not be made. Please try again. (' + message + ')'
        });
      },

      processPaymentResponse: function (res) {
        var result = res.tx;
        var statusCode = result.paymentType == 'account' ? result.acctvalrespcode : result.vbvrespcode;

        if (statusCode !== '00') {
          var responseMsg = (result.paymentType === 'account') ? result.acctvalrespmsg : result.vbvrespmessage;
          this.setErrorMessage(responseMsg);
        } else {
          this.placeOrder();
        }
      }
    });
  }
);
