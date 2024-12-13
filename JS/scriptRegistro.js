document.getElementById('registroForm').addEventListener('submit', function (event) {
  event.preventDefault();

  const nombre = document.getElementById('nombre').value;
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  if (password !== confirmPassword) {
    alert('Las contraseñas no coinciden.');
    return;
  }

  // Aquí podrías enviar los datos al servidor para registrarlos
  document.getElementById('mensaje').textContent = `¡Registro exitoso, ${nombre}!`;
});
