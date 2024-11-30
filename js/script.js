// Google Translate DropBox
function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: "en", // Default language of the page
      includedLanguages: "ar,en,fr,es", // Add languages as needed
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    },
    "google_translate_element"
  );
}
// Show Password Button
document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.getElementById("password");
  const showPasswordCheckbox = document.getElementById("showPassword");

  showPasswordCheckbox.addEventListener("change", function () {
    passwordInput.type = this.checked ? "text" : "password";
  });
});
