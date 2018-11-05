<?php include("common/header.php");?>
<script type="text/javascript" src="<?php echo base_url().'resources/frontend/js/telegram-passport.js'; ?>"></script>

<button type="button" id="telegram_passport_auth">Log In With Telegram</button>
<script>
  var auth_button = document.getElementById('telegram_passport_auth');
  var auth_params = {
    bot_id:        XXXXXX, // place id of your bot here
    scope:         ['id_document', 'address_document', 'phone_number', 'email'],
    public_key:    '-----BEGIN PUBLIC KEY----- ...', // place public key of your bot here
    payload:       'ab2df83746a87d2f3bd6...', // place payload here
    callback_url:  'https://example.com/callback/' // place callback url here
  };
  auth_button.addEventListener('click', function() {
      Telegram.Passport.auth(auth_params, function(show) {
      if (show) {
        // some code to show tooltip
      } else {
        // some code to hide tooltip
      }
    });
  }, false);
</script>
<?php include("common/footer.php");?>