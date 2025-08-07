function startDictation() {
  if (window.SpeechRecognition || window.webkitSpeechRecognition) {
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'en-US';
    recognition.start();

    recognition.onresult = function (event) {
      document.getElementById('searchInput').value = event.results[0][0].transcript;
    };
  } else {
    alert('Your browser does not support speech recognition.');
  }
}
