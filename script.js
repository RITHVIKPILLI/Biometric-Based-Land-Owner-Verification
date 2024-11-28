var allValue = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
var cVal1 = allValue[Math.floor(Math.random() * allValue.length)];
var cVal2 = allValue[Math.floor(Math.random() * allValue.length)];
var cVal3 = allValue[Math.floor(Math.random() * allValue.length)];
var cVal4 = allValue[Math.floor(Math.random() * allValue.length)];
var cVal5 = allValue[Math.floor(Math.random() * allValue.length)];
var cVal6 = allValue[Math.floor(Math.random() * allValue.length)];

var cValue = cVal1 + cVal2 + cVal3 + cVal4 + cVal5 + cVal6;
var captchaValue = document.getElementById('captchaValue');
var inputCaptcha = document.getElementById('inputCaptcha');
var submitBtn = document.querySelector('button[type="submit"]');

captchaValue.innerHTML = cValue;
var thisValue = "";

inputCaptcha.addEventListener('change', function() {
  thisValue = inputCaptcha.value;
});

submitBtn.addEventListener('click', function(event) {
  event.preventDefault();
  if (cValue == thisValue) {
    document.querySelector('form').submit();
  } else {
    alert('Invalid Captcha');
    cVal1 = allValue[Math.floor(Math.random() * allValue.length)];
    cVal2 = allValue[Math.floor(Math.random() * allValue.length)];
    cVal3 = allValue[Math.floor(Math.random() * allValue.length)];
    cVal4 = allValue[Math.floor(Math.random() * allValue.length)];
    cVal5 = allValue[Math.floor(Math.random() * allValue.length)];
    cVal6 = allValue[Math.floor(Math.random() * allValue.length)];
    cValue = cVal1 + cVal2 + cVal3 + cVal4 + cVal5 + cVal6;
    captchaValue.innerHTML = cValue;
    inputCaptcha.value = "";
  }
});
