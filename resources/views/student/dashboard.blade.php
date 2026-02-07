<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | RentConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    :root {
        --primary: rgb(38, 98, 227);
        --primary-hover: #1E4FD8;
        --text-main: #1F2937;
        --text-muted: #6B7280;
        --bg: #F3F4F6;
        --card-bg: #ffffff;
        --border: #E5E7EB;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        margin: 0;
        padding-bottom: 80px; /* bottom nav spacing */
        background: var(--bg);
    }

    .dashboard-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 16px;
    }

    /* Header */
    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .header-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
    }

    /* Emoji filter bar */
    .uni-filter-bar {
        display: flex;
        overflow-x: auto;
        gap: 12px;
        padding: 12px 4px;
        margin-bottom: 20px;
    }

    .uni-chip {
        background: var(--card-bg);
        padding: 10px 16px;
        border-radius: 20px;
        border: 1px solid var(--border);
        font-size: 15px;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(38,98,227,0.08);
    }

    .filter-btn {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        cursor: pointer;
    }

    /* Filter drawer */
    .filter-drawer {
        display: none;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(38,98,227,0.06);
    }

    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 12px;
    }

    .filter-row label {
        font-weight: 600;
    }

    .filter-row input,
    .filter-row select {
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #F9FAFB;
        min-width: 130px;
    }

    .apply-btn {
        background: var(--primary);
        color: #fff;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        width: 100%;
        margin-top: 10px;
    }

    /* Listings */
    .listings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
        gap: 24px;
    }

    .listing-card {
        background: white;
        padding: 16px;
        border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 10px rgba(38,98,227,0.06);
    }

    .listing-title {
        font-weight: 700;
        color: var(--primary);
        font-size: 18px;
    }

    .listing-meta {
        margin-top: 4px;
        color: var(--text-muted);
        font-size: 15px;
    }

    .listing-desc {
        margin-top: 10px;
        font-size: 15px;
        color: var(--text-main);
    }

    .listing-price {
        margin-top: 12px;
        font-weight: 700;
        color: var(--primary);
        font-size: 17px;
    }

    /* Bottom nav bar */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-around;
        padding: 10px 0 14px 0;
        box-shadow: 0 -2px 8px rgba(0,0,0,0.06);
    }

    .nav-item {
        font-size: 26px;
        cursor: pointer;
    }

    </style>
</head>

<body>

<div class="dashboard-container">

    <div class="header-row">
        <div class="header-title">Student Dashboard</div>
        <button class="filter-btn" id="filterToggle">Filters</button>
    </div>

    <!-- Emoji College Filter Bar -->
    <div class="uni-filter-bar">
        <div class="uni-chip">🎓 Trinity</div>
        <div class="uni-chip">🏛️ UCD</div>
        <div class="uni-chip">📚 TUD</div>
        <div class="uni-chip">🧪 DCU</div>
        <div class="uni-chip">🌉 UL</div>
        <div class="uni-chip">🌊 NUIG</div>
        <div class="uni-chip">🌿 Maynooth</div>
        <div class="uni-chip">⛪ RCSI</div>
        <div class="uni-chip">🎒 UCC</div>
    </div>

    <!-- Filter Drawer -->
    <div class="filter-drawer" id="filterDrawer">
        <form>

            <div class="filter-row">
                <label>Location</label>
                <input type="text" placeholder="Dublin">
            </div>

            <div class="filter-row">
                <label>House Type</label>
                <select>
                    <option>Any</option>
                    <option>Single Room in Private Home</option>
                    <option>Shared Student House</option>
                </select>
            </div>

            <div class="filter-row">
                <label>Available From</label>
                <input type="date">

                <label>Until</label>
                <input type="date">
            </div>

            <div class="filter-row">
                <label>Min Rent (€)</label>
                <input type="number" min="0">

                <label>Max Rent (€)</label>
                <input type="number" min="0">
            </div>

            <div class="filter-row">
                <label>Nights per Week</label>
                <select>
                    <option>Any</option>
                    <option>1–3 nights</option>
                    <option>4–5 nights</option>
                    <option>Full week</option>
                </select>
            </div>

            <button class="apply-btn">Apply Filters</button>
        </form>
    </div>

    <!-- Listings -->
    <div class="listings-grid">

        <div class="listing-card">
            <div class="listing-title">123 Main Street, Dublin</div>
            <div class="listing-meta">Shared • Available 1 Sept</div>
            <div class="listing-desc">Bright double room 10 mins from TUD.</div>
            <div class="listing-price">€650/month</div>
        </div>

        <div class="listing-card">
            <div class="listing-title">45 College Road, Galway</div>
            <div class="listing-meta">Private • Available 15 Aug</div>
            <div class="listing-desc">Studio near NUIG. All bills included.</div>
            <div class="listing-price">€900/month</div>
        </div>

    </div>

</div>

<!-- Bottom Nav -->
<div class="bottom-nav">
    <div class="nav-item">🏠</div>
    <div class="nav-item">💬</div>
    <div class="nav-item">👤</div>
    <div class="nav-item">⚙️</div>
</div>

<script>
    const toggleBtn = document.getElementById('filterToggle');
    const drawer = document.getElementById('filterDrawer');
    let open = false;

    toggleBtn.addEventListener('click', () => {
        open = !open;
        drawer.style.display = open ? 'block' : 'none';
        toggleBtn.textContent = open ? 'Hide Filters' : 'Filters';
    });
</script>

</body>
</html>