  console && console.debug && console.debug('assets/script.js loaded');

  /* ── GLOBAL STATE ── */
  let selectedActivities = {};

  /* ── MODAL ── */
  function openModal(tab) {
    const authModal = document.getElementById('authModal');
    if (!authModal) return;
    authModal.classList.add('open');
    switchTab(tab);
  }
  function closeModal() {
    const authModal = document.getElementById('authModal');
    if (!authModal) return;
    authModal.classList.remove('open');
  }
  // Modal event hookup is attached on DOMContentLoaded to avoid null refs

  function switchTab(tab) {
    const modalTabs = document.querySelectorAll('.modal-tab');
    modalTabs.forEach((t,i) => t.classList.toggle('active', (i===0&&tab==='login')||(i===1&&tab==='register')));
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    if (loginForm) loginForm.classList.toggle('active', tab==='login');
    if (registerForm) registerForm.classList.toggle('active', tab==='register');
  }

  /* ── DESTINATION FILTER ── */
  function filterDest(region, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.dest-card').forEach(card => {
      card.style.display = (region === 'all' || card.dataset.region === region) ? '' : 'none';
    });
  }

  /* ── SCROLL TO DEST ── */
  function scrollToDestinations() { document.getElementById('destinations').scrollIntoView({behavior:'smooth'}); }

  /* ── SELECT DEST ── */
  function selectDest(name) {
    const map = { 'Baguio City':'baguio', 'Boracay':'boracay', 'Cebu City':'cebu', 'Bukidnon':'bukidnon', 'Vigan':'vigan', 'Davao City':'davao', 'Camiguin':'camiguin' };
    const val = map[name];
    if (val) {
      document.getElementById('planDest').value = val;
      updateHotels();
      filterHotelsByKey(val);
    } else {
      // If we don't have a mapped key, still try to filter by name text
      document.querySelectorAll('.hotel-card').forEach(card => {
        const destEl = card.querySelector('.hotel-dest');
        if (!destEl) return;
        const txt = destEl.textContent || destEl.innerText || '';
        card.style.display = txt.toLowerCase().includes(name.toLowerCase()) ? '' : 'none';
      });
    }
    document.getElementById('itinerary').scrollIntoView({behavior:'smooth'});
  }

  /* ── HOTEL & ACTIVITY DATA ── */
  const destData = {
    baguio: {
      hotels: [
        {name:'Hotel Veniz', price:1800},
        {name:'Microtel by Wyndham Baguio', price:8500},
        {name:'Travelite Express Hotel', price:2500}
      ], 
      activities: ['Strawberry Picking at La Trinidad Farm ₱250','BenCab Museum Gallery Tour ₱200','Tree Top Adventure (Camp John Hay) ₱400','Igorot Stone Kingdom Exploration ₱150',],
      actPrices: [0,200,300,500,400]
    },
    boracay: {
      hotels: [
        {name:'Henann Resort Boracay', price:12000},
        {name:'Fairways & Bluewater', price:6000},
        {name:'La Carmela de Boracay Resort Hotel', price:1200}
      ],
      activities: ['Island Hopping ₱800','Parasailing Activity ₱2,000','Helmet Diving ₱700','ATV Ride ₱600'],
      actPrices: [800,1500,1200,600,900]
    },
    cebu: {
      hotels: [
        {name:'Quest Hotel Cebu', price:9000},
        {name:'Radisson Blu Cebu', price:5500},
        {name:'Bayfront Hotel Cebu', price:2200}
      ],
      activities: ['Kawasan Falls Canyoneering  ₱1,500','Temple of Leah Tour  ₱100','Oslob Whale Shark Watching  ₱500'],
      actPrices: [1500,100,500]
    },
    bukidnon: {
      hotels: [
        {name:'Dahilayan Forest Park Resort', price:3500},
        {name:'Ultrawinds Mountain Resort', price:4200},
        {name:'Secret Haven Private Resort', price:1500}
      ],
      activities: ['ATV (Dahilayan Adventure Park) ₱850','840m Zipline (Dahilayan Adventure park) ₱500','DropZone (Dahilayan Adventure park) ₱500','ZipKart  (Dahilayan Adventure park) ₱250'],
      actPrices: [850,500,500,250,400]
    },
    vigan: {
      hotels: [
        {name:'Hotel Felicidad Vigan', price:3200},
        {name:'Paradores de Vigan', price:2800},
        {name:'Hotel Luna', price:2600}
      ],
      activities: ['Calesa Ride around Calle Crisologo (₱250)','Pagburnayan Jar Factory Pottery Making ₱300','Vigan Museum / Syquia Mansion Tour ₱180'],
      actPrices: [250,300,150,200,0]
    },
    palawan: {
      hotels: [
        {name:'Seda Lio (El Nido) ', price:6000},
        {name:'Hue Hotels and Resorts', price:4200},
        {name:'Two Seasons Coron Island Resort', price:8500}
      ],
      activities: ['El Nido Tour A (Lagoons & Islands) ₱1,200','Puerto Princesa Underground River Tour ₱2,750','Coron Ultimate Shipwreck & Snorkeling Tour ₱1,600', 'Wildlife Safari Tour at Calauit Sanctuary ₱2,500'],
      actPrices: [1200,2750,1600,2500,800]
    },
    siargao: {
      hotels: [
        {name:'Villa Cali', price:7500},
        {name:'Nay Palad Hideawa', price:3800},
        {name:'Kalinaw Resort', price:2800}
      ],
      activities: ['Island Hopping ₱2,000','Basic Surfing Lesson ₱700','Motorbike Rental ₱500','Sugba Lagoon Tour ₱1,200'],
      actPrices: [2000,700,500,1200]
    }
  };

  const destNames = {baguio:'Baguio City',boracay:'Boracay',cebu:'Cebu City',bukidnon:'Bukidnon',vigan:'Vigan City',palawan:'Palawan',siargao:'Siargao Island',davao:'Davao City',camiguin:'Camiguin'};

  function updateHotels() {
    try {
    const dest = document.getElementById('planDest').value;
    const hotelSel = document.getElementById('planHotel');
    const actGrid = document.getElementById('activitiesGrid');
    console && console.debug && console.debug('updateHotels called, dest=', dest, 'hotelSel=', !!hotelSel, 'actGrid=', !!actGrid);
    if (!hotelSel) { console && console.error && console.error('planHotel select not found'); return; }
    hotelSel.innerHTML = '<option value="">Select hotel...</option>';
    selectedActivities = {};
    if (!dest) { actGrid.innerHTML = ''; filterHotelsByKey(''); return; }
    // dest may be a short key like 'baguio' or a full name like 'Baguio City'.
    let d = destData[dest];
    let useKey = dest;
    if (!d) {
      // try to resolve the key from destNames mapping
      for (const k in destNames) {
        const nm = (destNames[k] || '').toLowerCase();
        const val = (dest || '').toLowerCase();
        if (!nm) continue;
        if (val === k.toLowerCase() || val === nm || nm.includes(val) || val.includes(nm)) {
          d = destData[k];
          useKey = k;
          break;
        }
      }
    }
    if (!d) {
      // No data for this destination — clear activities and filter hotels by key/text
      console && console.debug && console.debug('No destData for', dest, 'resolved useKey=', useKey);
      actGrid.innerHTML = '';
      filterHotelsByKey(dest);
      updateSummary();
      return;
    }
    d.hotels.forEach((h,i) => {
      hotelSel.innerHTML += `<option value="${h.price}">${h.name} — ₱${h.price.toLocaleString()}/night</option>`;
    });
    console && console.debug && console.debug('Populated', d.hotels.length, 'hotels into planHotel');
    actGrid.innerHTML = d.activities.map((a,i) =>
      `<div class="activity-check" onclick="toggleActivity(this,${d.actPrices[i]})"><div class="check-icon"></div> ${a}</div>`
    ).join('');
    // Filter the hotels grid to show only hotels for this destination
    filterHotelsByKey(useKey || dest);
    updateSummary();
    } catch (err) {
      console && console.error && console.error('updateHotels error', err);
    }
  }

  function filterHotelsByKey(key) {
    const cards = document.querySelectorAll('.hotel-card');
    if (!key) { cards.forEach(c => c.style.display = ''); return; }
    const name = destNames[key] || '';
    cards.forEach(card => {
      // Prefer a data attribute if present for robust matching
      const dataDest = (card.dataset && card.dataset.destination) ? card.dataset.destination.toLowerCase() : '';
      if (dataDest) {
        card.style.display = (dataDest === key.toLowerCase() || dataDest.includes(key.toLowerCase())) ? '' : 'none';
        return;
      }
      const destEl = card.querySelector('.hotel-dest');
      if (!destEl) { card.style.display = ''; return; }
      const txt = destEl.textContent || destEl.innerText || '';
      card.style.display = txt.toLowerCase().includes(name.toLowerCase()) ? '' : 'none';
    });
  }

  function toggleActivity(el, price) {
    el.classList.toggle('checked');
    const key = el.textContent.trim();
    if (el.classList.contains('checked')) selectedActivities[key] = price;
    else delete selectedActivities[key];
    updateSummary();
  }

  function updateSummary() {
    const dest = document.getElementById('planDest');
    const hotel = document.getElementById('planHotel');
    const ci = document.getElementById('planCheckIn').value;
    const co = document.getElementById('planCheckOut').value;
    if (!dest.value || !hotel.value || !ci || !co) {
      document.getElementById('builderSummary').classList.remove('show');
      return;
    }
    const nights = Math.max(0, (new Date(co)-new Date(ci))/(1000*60*60*24));
    const hotelCost = parseInt(hotel.value) * nights;
    const actCost = Object.values(selectedActivities).reduce((a,b)=>a+b,0);
    const total = hotelCost + actCost;
    const destNames = {baguio:'Baguio City',boracay:'Boracay',cebu:'Cebu City',bukidnon:'Bukidnon'};
    document.getElementById('sumDest').textContent = destNames[dest.value] || '—';
    document.getElementById('sumHotel').textContent = hotel.options[hotel.selectedIndex].text.split('—')[0].trim();
    document.getElementById('sumDates').textContent = `${ci} → ${co}`;
    document.getElementById('sumNights').textContent = nights + (nights===1?' night':' nights');
    document.getElementById('sumHotelCost').textContent = '₱' + hotelCost.toLocaleString();
    document.getElementById('sumActCost').textContent = '₱' + actCost.toLocaleString();
    document.getElementById('sumTotal').textContent = '₱' + total.toLocaleString();
    document.getElementById('builderSummary').classList.add('show');
  }

  function confirmBooking() {
    const dest = document.getElementById('planDest').value;
    if (!dest) { alert('Please select a destination first!'); return; }
    alert('✅ Booking confirmed! (This would redirect to the checkout/payment page in the full system.)');
  }

  // Ensure the hotels and filters initialize if a destination is already selected on page load
  window.addEventListener('DOMContentLoaded', function() {
    try {
      const sel = document.getElementById('planDest');
      // Attach modal click handler here to ensure element exists
      const authModalElement = document.getElementById('authModal');
      if (authModalElement) {
        authModalElement.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
      }
      if (sel && sel.value) {
        updateHotels();
      } else {
        // If no selection, ensure hotel cards are visible
        filterHotelsByKey('');
      }
    } catch (e) {
      console && console.warn && console.warn('Itinerary init error:', e);
    }
  });