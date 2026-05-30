<?php
require_once 'data.php';

$destId  = $_GET['dest'] ?? '';
$hotelId = $_GET['id']   ?? '';
$dest    = getDestById($destId);
$hotel   = getHotelById($destId, $hotelId);

if (!$dest || !$hotel) {
  header('Location: destinations.php');
  exit;
}

$pageTitle  = $hotel['name'] . ' — LakbayLokal';
$activePage = 'destinations';
$rootPath   = '';
include 'includes/header.php';

$amenityIcons = [
  'Free WiFi' => '📶', 'Pool' => '🏊', 'Restaurant' => '🍽️', 'Gym' => '💪',
  'Spa' => '💆', 'Parking' => '🅿️', 'Breakfast' => '🍳', 'Breakfast Included' => '🍳',
  'Beach Access' => '🏖️', 'Beachfront' => '🌊', 'Airport Shuttle' => '🚌',
  'Room Service' => '🛎️', 'Laundry' => '👕', 'Laundry Service' => '👕',
  'Concierge' => '🤵', 'Bike Rental' => '🚲', 'Bicycle Rental' => '🚲',
  'Water Sports' => '🤿', 'Golf Course' => '⛳', 'Tennis' => '🎾',
  'Infinity Pool' => '🏊', 'Rooftop Pool' => '🏊', '3 Pools' => '🏊',
  'Art Gallery' => '🎨', 'Dive Center' => '🤿', 'Kayaking' => '🚣',
  'Snorkeling Gear' => '🤿', 'Butler Service' => '🤵', 'Organic Restaurant' => '🍽️',
  'Surfing Access' => '🏄', 'Kids Club' => '🧸', 'Business Center' => '💼',
  'Multiple Restaurants' => '🍽️', 'Multiple Pools' => '🏊', 'Tour Desk' => '🗺️',
  'Hammock Garden' => '🌿', 'Common Area' => '🛋️', 'Courtyard Garden' => '🌿',
  'Surf Board Rental' => '🏄', 'Surfboard Storage' => '🏄', 'Breakfast Available' => '🍳',
  'Overwater Villas' => '🏝️', 'Private Beach' => '🏖️', 'Beachfront Location' => '🌊',
  'Event Halls' => '🎪', '24/7 Front Desk' => '🔑', 'Air Conditioning' => '❄️',
  'Adventure Park Access' => '🎢', 'Bonfire Area' => '🔥', 'Mountain View' => '⛰️',
  'BBQ Area' => '🍖', 'Exclusive Use' => '🔒', 'Kitchen Facilities' => '🍴',
  'Communal Kitchen' => '🍴', 'Outdoor Bar' => '🍹', 'Lagoon Views' => '💧',
  'Hammocks' => '🌴',
];
$stars = str_repeat('★', $hotel['stars']) . str_repeat('☆', 5 - $hotel['stars']);
?>

<div class="page-wrapper">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Home</a>
    <span class="breadcrumb-sep">›</span>
    <a href="destinations.php">Destinations</a>
    <span class="breadcrumb-sep">›</span>
    <a href="destinations.php?dest=<?= $destId ?>"><?= htmlspecialchars($dest['name']) ?></a>
    <span class="breadcrumb-sep">›</span>
    <span><?= htmlspecialchars($hotel['name']) ?></span>
  </div>

  <!-- Hotel Hero -->
  <div class="hotel-detail-hero" style="background: <?= $dest['gradient'] ?>;">
    <div class="hotel-detail-hero-overlay"></div>
    <div class="hotel-detail-hero-content">
      <div class="hotel-stars-big"><?= $stars ?></div>
      <h1><?= htmlspecialchars($hotel['name']) ?></h1>
      <div class="hotel-loc">
        📍 <?= htmlspecialchars($hotel['location']) ?>
        <span class="hotel-rating-pill">⭐ <?= $hotel['rating'] ?> (<?= $hotel['reviews'] ?> reviews)</span>
      </div>
    </div>
  </div>

  <!-- Main Two-Column Layout -->
  <div class="hotel-detail-layout">

    <!-- LEFT: Hotel Info + Activities -->
    <div>

      <!-- About -->
      <div class="hotel-info-section">
        <h2>About This Hotel</h2>
        <p class="hotel-desc-text"><?= htmlspecialchars($hotel['desc']) ?></p>
      </div>

      <!-- Amenities -->
      <div class="hotel-info-section">
        <h2>Amenities &amp; Facilities</h2>
        <div class="amenities-grid">
          <?php foreach ($hotel['amenities'] as $am): ?>
            <div class="amenity-item">
              <span class="amenity-icon"><?= $amenityIcons[$am] ?? '✓' ?></span>
              <span><?= htmlspecialchars($am) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Check-in / Check-out -->
      <div class="hotel-info-section">
        <h2>Check-in &amp; Check-out</h2>
        <div class="checkinout-grid">
          <div class="checkinout-box">
            <div class="cio-label">Check-in from</div>
            <div class="cio-time"><?= $hotel['checkin'] ?></div>
          </div>
          <div class="checkinout-box">
            <div class="cio-label">Check-out before</div>
            <div class="cio-time"><?= $hotel['checkout'] ?></div>
          </div>
        </div>
      </div>

      <!-- Activities -->
      <div class="hotel-info-section" id="activitiesSection">
        <h2>🎯 Activities in <?= htmlspecialchars($dest['name']) ?></h2>
        <p style="color:var(--muted);font-size:0.88rem;margin-bottom:1.2rem;">Select activities to add to your booking. Prices will be reflected in your total.</p>
        <div id="activityList">
          <?php foreach ($dest['acts'] as $i => $act): ?>
            <div class="activity-item" id="act-<?= $i ?>"
                 data-name="<?= htmlspecialchars($act['name']) ?>"
                 data-price="<?= $act['price'] ?>"
                 onclick="toggleActivity(<?= $i ?>)">
              <div>
                <div class="activity-name"><?= htmlspecialchars($act['name']) ?></div>
              </div>
              <div style="display:flex;align-items:center;gap:12px;">
                <span class="activity-price">₱<?= number_format($act['price']) ?></span>
                <div class="activity-check"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Policies -->
      <div class="hotel-info-section">
        <h2>Property Policies</h2>
        <ul class="policy-list">
          <?php foreach ($hotel['policies'] as $p): ?>
            <li><?= htmlspecialchars($p) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Other Hotels -->
      <div class="hotel-info-section">
        <h2>Other Hotels in <?= htmlspecialchars($dest['name']) ?></h2>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
          <?php foreach ($dest['hotels'] as $h):
            if ($h['id'] === $hotelId) continue; ?>
            <a href="hotel.php?dest=<?= $destId ?>&id=<?= $h['id'] ?>"
               style="display:flex;align-items:center;justify-content:space-between;padding:0.9rem 1rem;background:var(--cream);border-radius:var(--radius-sm);text-decoration:none;color:inherit;border:1px solid var(--border);transition:all 0.2s;"
               onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
              <div>
                <div style="font-weight:600;font-size:0.9rem;"><?= htmlspecialchars($h['name']) ?></div>
                <div style="font-size:0.78rem;color:var(--muted);">⭐ <?= $h['rating'] ?> · <?= str_repeat('★', $h['stars']) ?></div>
              </div>
              <div style="text-align:right;">
                <div style="font-weight:700;color:var(--primary);font-size:0.95rem;">₱<?= number_format($h['price']) ?></div>
                <div style="font-size:0.72rem;color:var(--muted);">per night</div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

    </div><!-- /left column -->

    <!-- RIGHT: Booking Form -->
    <div>
      <div class="booking-form-card" id="bookingCard">
        <h3>Book This Hotel</h3>
        <div class="booking-price-preview">
          <span class="price-big">₱<?= number_format($hotel['price']) ?></span>
          <span class="price-unit">/ night</span>
        </div>

        <form action="booking_confirm.php" method="POST" id="bookingForm">
          <input type="hidden" name="dest_id"        value="<?= htmlspecialchars($destId) ?>">
          <input type="hidden" name="hotel_id"       value="<?= htmlspecialchars($hotelId) ?>">
          <input type="hidden" name="dest_name"      value="<?= htmlspecialchars($dest['name']) ?>">
          <input type="hidden" name="hotel_name"     value="<?= htmlspecialchars($hotel['name']) ?>">
          <input type="hidden" name="price_per_night" value="<?= $hotel['price'] ?>">
          <input type="hidden" name="dest_gradient"  value="<?= htmlspecialchars($dest['gradient']) ?>">
          <input type="hidden" name="dest_emoji"     value="<?= $dest['emoji'] ?>">
          <input type="hidden" name="selected_acts"  id="selectedActsInput" value="">

          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="guest_name" placeholder="Juan dela Cruz" required>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="guest_email" placeholder="juan@email.com" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Check-in Date</label>
              <input type="date" name="checkin" id="checkinInput" min="<?= date('Y-m-d') ?>" required onchange="calcTotal()">
            </div>
            <div class="form-group">
              <label>Check-out Date</label>
              <input type="date" name="checkout" id="checkoutInput" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required onchange="calcTotal()">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Guests</label>
              <select name="guests">
                <option value="1">1 Guest</option>
                <option value="2" selected>2 Guests</option>
                <option value="3">3 Guests</option>
                <option value="4">4 Guests</option>
                <option value="5">5+ Guests</option>
              </select>
            </div>
            <div class="form-group">
              <label>Rooms</label>
              <select name="rooms" id="roomsInput" onchange="calcTotal()">
                <option value="1">1 Room</option>
                <option value="2">2 Rooms</option>
                <option value="3">3 Rooms</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Special Requests (optional)</label>
            <input type="text" name="requests" placeholder="e.g. early check-in, high floor...">
          </div>

          <!-- Price Breakdown -->
          <div class="booking-summary-breakdown">
            <div class="breakdown-row"><span>Price per night</span><strong>₱<?= number_format($hotel['price']) ?></strong></div>
            <div class="breakdown-row"><span>Nights</span><strong id="nightsDisplay">—</strong></div>
            <div class="breakdown-row"><span>Rooms</span><strong id="roomsDisplay">1</strong></div>
            <div class="breakdown-row" id="actsRow" style="display:none;"><span>Activities</span><strong id="actsDisplay">—</strong></div>
            <div class="breakdown-row"><span>Taxes &amp; Fees (12%)</span><strong id="taxDisplay">—</strong></div>
            <div class="breakdown-row" style="font-weight:700;font-size:0.95rem;border-bottom:none;"><span>Total</span><strong id="totalDisplay" style="color:var(--primary);">—</strong></div>
          </div>
          <input type="hidden" name="total_price" id="totalInput" value="0">
          <input type="hidden" name="nights"      id="nightsInput" value="0">
          <input type="hidden" name="acts_total"  id="actsTotalInput" value="0">

          <button type="submit" class="book-now-btn" onclick="return prepareSubmit()">
            Confirm Booking →
          </button>
        </form>

        <p style="font-size:0.75rem;color:var(--muted);text-align:center;margin-top:0.8rem;">
          🔒 Secure booking · Free cancellation within 24hrs
        </p>
      </div>
    </div>

  </div><!-- /hotel-detail-layout -->

</div><!-- /page-wrapper -->

<?php include 'includes/footer.php'; ?>

<script>
const PRICE_PER_NIGHT = <?= $hotel['price'] ?>;
let selectedActivities = {}; // { index: { name, price } }

// ── Activity toggle ──
function toggleActivity(i) {
  const el    = document.getElementById('act-' + i);
  const name  = el.dataset.name;
  const price = parseInt(el.dataset.price);

  if (selectedActivities[i]) {
    delete selectedActivities[i];
    el.classList.remove('checked');
  } else {
    selectedActivities[i] = { name, price };
    el.classList.add('checked');
  }
  calcTotal();
}

// ── Calculate total ──
function calcTotal() {
  const checkin  = document.getElementById('checkinInput').value;
  const checkout = document.getElementById('checkoutInput').value;
  const rooms    = parseInt(document.getElementById('roomsInput').value) || 1;
  const actsTotal = Object.values(selectedActivities).reduce((s, a) => s + a.price, 0);

  // Update acts row
  const actKeys = Object.values(selectedActivities);
  if (actKeys.length > 0) {
    document.getElementById('actsRow').style.display = 'flex';
    document.getElementById('actsDisplay').textContent = actKeys.length + ' selected (+₱' + actsTotal.toLocaleString() + ')';
  } else {
    document.getElementById('actsRow').style.display = 'none';
  }

  document.getElementById('actsTotalInput').value = actsTotal;

  if (checkin && checkout) {
    const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
    if (nights > 0) {
      const hotel    = PRICE_PER_NIGHT * nights * rooms;
      const subtotal = hotel + actsTotal;
      const tax      = Math.round(subtotal * 0.12);
      const total    = subtotal + tax;

      document.getElementById('nightsDisplay').textContent = nights + (nights === 1 ? ' night' : ' nights');
      document.getElementById('roomsDisplay').textContent  = rooms + (rooms === 1 ? ' room' : ' rooms');
      document.getElementById('taxDisplay').textContent    = '₱' + tax.toLocaleString();
      document.getElementById('totalDisplay').textContent  = '₱' + total.toLocaleString();
      document.getElementById('totalInput').value          = total;
      document.getElementById('nightsInput').value         = nights;
      return;
    }
  }
  document.getElementById('nightsDisplay').textContent = '—';
  document.getElementById('taxDisplay').textContent    = '—';
  document.getElementById('totalDisplay').textContent  = '—';
}

// ── Pre-submit: validate & pack activities ──
function prepareSubmit() {
  const checkin  = document.getElementById('checkinInput').value;
  const checkout = document.getElementById('checkoutInput').value;
  if (!checkin || !checkout) {
    alert('Please select check-in and check-out dates.');
    return false;
  }
  const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
  if (nights < 1) {
    alert('Check-out must be after check-in.');
    return false;
  }
  // Pack selected activities as JSON string for PHP
  document.getElementById('selectedActsInput').value = JSON.stringify(Object.values(selectedActivities));
  return true;
}
</script>
