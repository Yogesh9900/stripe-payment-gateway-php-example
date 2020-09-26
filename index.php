<?php require_once('./sample-config.php'); ?>

<form action="sample-charge.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-description="Test description"
          data-amount="100"
          data-locale="auto"></script>       
</form>

 <!-- You can customise your button using follwing code -->
 <!--   Hide default stripe button, be careful there if you
         have more than 1 button of that class 
        <script>
         document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
    </script>
    <button type="submit" class="yourCustomClass">Buy my things</button> -->
