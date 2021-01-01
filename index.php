<?php
require_once  'config.php';
if(isset($_GET['tur']) && !empty($_GET['tur']) && isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['paket']) && !empty($_GET['paket'])) {
    $tur = htmlspecialchars(trim($_GET['tur']));
    $id=htmlspecialchars(trim($_GET['id']));
    $paket=htmlspecialchars(trim($_GET['paket']));
    if ($tur == 'sb') {
        /// bilgilerini çek
      // $bilgilerim=Bilgilerim($id);
      // $paketlerim=Paketlerim($paket);

    }
    if ($tur == 'r') {
        /// bilgilerini çek
    }
    if ($tur == 's') {
        /// bilgilerini çek
    }
}else{
    echo 'tur,id,paket bilgisi yok';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
  </head>
  <body>
    <!-- Display a payment form -->
    <form id="payment-form">
       <!-- <input type="text" id="email" placeholder="Email address" />-->
      <div id="card-element"><!--Stripe.js injects the Card Element--></div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text"> <?=$paketlerim['ucret'] ?>₺  &#128274; Güvenili Ödeme Yap </span>
      </button>
        <br>
        <center>
            Üye : <?=$bilgilerim['username']?><br>
            Güvenilir Ödeme by Adyen.Com<br>
             <img src="https://www.wcollection.com.tr/Content/Images/footer-cards.png"><br>
            %100 Güvenilir 256 bit Şifreleme ile Korunmaktadır!<br>Kart bilgilerinizi hiç bir ikinci şahısın görme ihtimali yoktur!
            <span class="token"><br> Not: Kartınızın internet (Yurtiçi & Yurtdışı) kullanımına açık olması gerekmektedir.</span>
        </center>
      <p id="card-error" role="alert"></p>
      <p class="result-message hidden">
        Ödeme Başarılı Gerekli güncellemeler yapıldı. İyi Seyirler.
        <a href="" target="_blank">Anasayfa.</a>
      </p>
    </form>
  <script>
      // A reference to Stripe.js initialized with a fake API key.
      // Sign in to see examples pre-filled with your key.
      //var stripe = Stripe("pk_test_51HoXNMCFItecRlmLGmlopJL1YTdDsVR00HB830NSmXz1X5E6ePVCvYRJGFQDiheVgcTlos8Y7H4m0daXEkJWpivH00jbwjqxta");
      // The items the customer wants to buy
      var stripe = Stripe('<?=PKKEY?>', {
          locale: 'tr'
      });

      // Disable the button until we have Stripe set up on the page
      document.querySelector("button").disabled = true;
      fetch("create.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify()
      })
          .then(function(result) {
              return result.json();
          })
          .then(function(data) {
              var elements = stripe.elements();

              var style = {
                  base: {
                      color: "#32325d",
                      fontFamily: 'Arial, sans-serif',
                      fontSmoothing: "antialiased",
                      fontSize: "16px",
                      "::placeholder": {
                          color: "#32325d"
                      }
                  },
                  invalid: {
                      fontFamily: 'Arial, sans-serif',
                      color: "#fa755a",
                      iconColor: "#fa755a"
                  }
              };

              var card = elements.create("card", { style: style });
              // Stripe injects an iframe into the DOM
              card.mount("#card-element");

              card.on("change", function (event) {
                  // Disable the Pay button if there are no card details in the Element
                  document.querySelector("button").disabled = event.empty;
                  document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
              });

              var form = document.getElementById("payment-form");
              form.addEventListener("submit", function(event) {
                  event.preventDefault();
                  // Complete payment when the submit button is clicked
                  payWithCard(stripe, card, data.clientSecret);
              });
          });

      // Calls stripe.confirmCardPayment
      // If the card requires authentication Stripe shows a pop-up modal to
      // prompt the user to enter authentication details without leaving your page.
      var payWithCard = function(stripe, card, clientSecret) {
          loading(true);
          stripe
              .confirmCardPayment(clientSecret, {
                  payment_method: {
                      card: card
                  }
              })
              .then(function(result) {
                  if (result.error) {
                      // Show error to your customer
                      showError(result.error.message);
                  } else {
                      // The payment succeeded!
                      orderComplete(result.paymentIntent.id);

                  }
              });
      };

      /* ------- UI helpers ------- */

      // Shows a success message when the payment is complete
      var orderComplete = function(paymentIntentId) {
          loading(false);
          document
              .querySelector(".result-message a")
              .setAttribute(
                  "href",
                  "https://dashboard.stripe.com//payments/" + paymentIntentId
              );
          document.querySelector(".result-message").classList.remove("hidden");
          document.querySelector("button").disabled = true;
          window.location.href = "result.php?intent=" + paymentIntentId;
      };

      // Show the customer the error from Stripe if their card fails to charge
      var showError = function(errorMsgText) {
          loading(false);
          var errorMsg = document.querySelector("#card-error");
          errorMsg.textContent = errorMsgText;
          setTimeout(function() {
              errorMsg.textContent = "";
          }, 4000);
      };

      // Show a spinner on payment submission
      var loading = function(isLoading) {
          if (isLoading) {
              // Disable the button and show a spinner
              document.querySelector("button").disabled = true;
              document.querySelector("#spinner").classList.remove("hidden");
              document.querySelector("#button-text").classList.add("hidden");
          } else {
              document.querySelector("button").disabled = false;
              document.querySelector("#spinner").classList.add("hidden");
              document.querySelector("#button-text").classList.remove("hidden");
          }
      };

  </script>
  </body>
</html>


