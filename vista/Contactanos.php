<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contáctenos</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://upload.wikimedia.org/wikipedia/commons/9/9d/Baile_de_cortejo_Wayuu.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      background: #ffffffcc;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    h1 {
      font-size: 2.5em;
      color: #111;
      margin-bottom: 25px;
      border-bottom: 2px solid #d0f0f0;
      padding-bottom: 10px;
    }

    .section {
      margin-bottom: 25px;
    }

    .section h2 {
      font-size: 1.2em;
      color: #222;
      margin-bottom: 10px;
    }

    .contact-card {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      background: #f0fafa;
      border-radius: 12px;
      transition: background 0.2s ease;
    }

    .contact-card:hover {
      background: #dff3f3;
    }

    .icon {
      width: 42px;
      height: 42px;
      min-width: 42px;
      background: #14b8a6;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }

    .icon svg {
      fill: #fff;
      width: 20px;
      height: 20px;
    }

    .info {
      display: flex;
      flex-direction: column;
    }

    .label {
      font-size: 0.75em;
      color: #666;
    }

    .number {
      font-size: 1em;
      color: #000;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Contáctenos</h1>

    <div class="section">
      <h2>Coordinadora general</h2>
      <div class="contact-card">
        <div class="icon">
          <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.72 11.72 0 004.3 1.14 1 1 0 011 1v3.61a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h3.61a1 1 0 011 1 11.72 11.72 0 001.14 4.3 1 1 0 01-.21 1.11z"/></svg>
        </div>
        <div class="info">
          <div class="label">CELULAR</div>
          <div class="number">314 555 5004</div>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>Gerente del programa</h2>
      <div class="contact-card">
        <div class="icon">
          <svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.72 11.72 0 004.3 1.14 1 1 0 011 1v3.61a1 1 0 01-1 1A17 17 0 013 5a1 1 0 011-1h3.61a1 1 0 011 1 11.72 11.72 0 001.14 4.3 1 1 0 01-.21 1.11z"/></svg>
        </div>
        <div class="info">
          <div class="label">CELULAR</div>
          <div class="number">300 578 7896</div>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>coordinadora general</h2>
      <div class="contact-card">
        <div class="icon">
          <svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm-1 2l-7 5-7-5h14zm1 12H4V8l8 5.5L20 8v10z"/></svg>
        </div>
        <div class="info">
          <div class="label">CORREO</div>
          <div class="number">gmail.com</div>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>gerente del programa</h2>
      <div class="contact-card">
        <div class="icon">
          <svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm-1 2l-7 5-7-5h14zm1 12H4V8l8 5.5L20 8v10z"/></svg>
        </div>
        <div class="info">
          <div class="label">CORREO</div>
          <div class="number">@gmail.com</div>
        </div>
      </div>
    </div>

</body>
</html>
