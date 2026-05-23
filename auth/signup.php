<div class="modal-overlay" id="authModal">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <h2>Welcome to LakbayPH</h2>
    <div class="modal-tabs">
      <div class="modal-tab active" onclick="switchTab('login')">Log In</div>
      <div class="modal-tab" onclick="switchTab('register')">Register</div>
    </div>
    <div class="modal-form active" id="loginForm">
      <input type="email" placeholder="Email address" />
      <input type="password" placeholder="Password" />
      <button class="btn-modal">Log In</button>
    </div>
    <div class="modal-form" id="registerForm">
      <input type="text" placeholder="Full name" />
      <input type="email" placeholder="Email address" />
      <input type="password" placeholder="Password" />
      <input type="password" placeholder="Confirm password" />
      <button class="btn-modal">Create Account</button>
    </div>
  </div>
</div>