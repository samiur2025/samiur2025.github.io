<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2B Prospect Sample — Dimarz</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0c0c14;
            --bg-card: #161628;
            --bg-hover: #1e1e36;
            --text: #e8e8f0;
            --text-dim: #9090b0;
            --text-muted: #606080;
            --border: #2a2a48;
            --accent-cyan: #00f0ff;
            --secondary: #ff2a6d;
            --accent-purple: #9d4edd;
            --accent-blue: #3b82f6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* Header */
        .page-header {
            text-align: center;
            padding: 56px 48px 0;
            margin-bottom: 20px;
            max-width: 800px;
        }

        .page-tag {
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--accent-cyan);
            margin-bottom: 12px;
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.15);
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--text) 30%, var(--accent-cyan), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-style: italic;
            color: var(--text-dim);
            margin-bottom: 48px;
        }

        /* Window Container */
        .window-container {
            width: 100%;
            max-width: 1400px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Window Top Bar */
        .window-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            background: #111522;
        }

        .window-dots {
            display: flex;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .dot.red { background: #ff5f56; }
        .dot.yellow { background: #ffbd2e; }
        .dot.green { background: #27c93f; }

        .window-search {
            background: var(--bg);
            border: 1px solid rgba(157, 78, 221, 0.5);
            border-radius: 6px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(157, 78, 221, 0.2);
            transition: all 0.3s ease;
            animation: pulseGlow 2.5s infinite;
        }

        .window-search:focus-within {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
            animation: none;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 10px rgba(157, 78, 221, 0.2); }
            50% { box-shadow: 0 0 20px rgba(157, 78, 221, 0.5); border-color: var(--accent-purple); }
            100% { box-shadow: 0 0 10px rgba(157, 78, 221, 0.2); }
        }

        .window-search svg {
            width: 14px;
            height: 14px;
            fill: none;
            stroke: #ffffff;
            stroke-width: 2;
        }

        .window-search input {
            background: transparent;
            border: none;
            color: var(--text);
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            width: 100%;
            outline: none;
        }

        .window-search input::placeholder {
            color: #64748b;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent-purple);
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        td {
            padding: 12px 20px;
            font-family: 'Space Mono', monospace;
            font-size: 0.8rem;
            color: var(--text);
            border-bottom: 1px solid rgba(46, 60, 84, 0.4);
            white-space: nowrap;
            transition: background 0.2s;
        }

        tr:hover td {
            background: var(--bg-hover);
        }

        /* Specific Column Styles */
        .col-company { color: var(--accent-purple); }
        .col-email { color: var(--accent-blue); text-decoration: none; }
        .col-website { color: var(--accent-blue); text-decoration: underline; text-decoration-color: rgba(59, 130, 246, 0.3); text-underline-offset: 4px; }
        
        .row-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .row-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--text);
            margin-right: 8px;
            opacity: 0.5;
        }

        /* Bottom Bar */
        .window-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: #111522;
            border-top: 1px solid var(--border);
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            color: var(--text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .uplink-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .uplink-bar-container {
            width: 200px;
            height: 4px;
            background: rgba(157, 78, 221, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-left: 12px;
        }

        .uplink-bar {
            width: 60%;
            height: 100%;
            background: var(--accent-purple);
            box-shadow: 0 0 10px var(--accent-purple);
            animation: scan 2s infinite ease-in-out;
        }

        @keyframes scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }

        /* Close Button */
        .page-close {
            position: fixed;
            top: 30px;
            right: 40px;
            width: 44px;
            height: 44px;
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            background: var(--bg-card);
            z-index: 100;
        }

        .page-close:hover {
            color: #ff5f56;
            border-color: #ff5f56;
            background: rgba(255, 95, 86, 0.1);
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 95, 86, 0.2);
        }

        .page-close svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
        }

        @media (max-width: 768px) {
            .page-close {
                top: 20px;
                right: 20px;
                width: 36px;
                height: 36px;
            }
            .page-close svg { width: 16px; height: 16px; }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="leadTable()" x-init="init()">

    <a href="{{ route('portfolio') }}" class="page-close" title="Back to Portfolio">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </a>

    <div class="page-header">
        <div class="page-tag">Live Dataset</div>
        <h1 class="page-title">B2B PROSPECT SAMPLE</h1>
        <p class="page-subtitle">Explore a curated selection of our high-quality B2B leads. Experience the depth and accuracy of our verification engine firsthand.</p>
    </div>

    <div class="window-container">
        <!-- Top Bar -->
        <div class="window-topbar">
            <div class="window-dots">
                <div class="dot red"></div>
                <div class="dot yellow"></div>
                <div class="dot green"></div>
            </div>
            <div class="window-search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Query dataset (e.g. 'CEO', 'Tech', 'USA')" x-model="query" @input.debounce.250ms="updateDisplay()">
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Identifier</th>
                        <th>Sector</th>
                        <th>Niche</th>
                        <th>Company</th>
                        <th>Lead</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Website</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="lead in displayedLeads" :key="lead.email">
                        <tr>
                            <td>
                                <div class="row-pill" x-text="lead.identifier"></div>
                            </td>
                            <td style="color: #94a3b8;" x-text="lead.sector"></td>
                            <td style="color: #e2e8f0;" x-text="lead.niche"></td>
                            <td class="col-company" x-text="lead.company"></td>
                            <td style="color: #ffffff; font-weight: 500;" x-text="lead.lead"></td>
                            <td style="color: #94a3b8;" x-text="lead.role"></td>
                            <td><a :href="'mailto:' + lead.email" class="col-email" x-text="lead.email"></a></td>
                            <td style="color: #e2e8f0;" x-text="lead.phone"></td>
                            <td><a :href="'http://' + lead.website" target="_blank" class="col-website" x-text="lead.website"></a></td>
                            <td style="color: #94a3b8;" x-text="lead.location"></td>
                        </tr>
                    </template>
                    <tr x-show="displayedLeads.length === 0">
                        <td colspan="10" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            No data available for this query.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bottom Bar -->
        <div class="window-bottom">
            <div class="uplink-status">
                ENCRYPTED_UPLINK: ACTIVE
                <div class="uplink-bar-container">
                    <div class="uplink-bar"></div>
                </div>
            </div>
            <div class="records-count">
                RECORDS: <span x-text="displayedLeads.length"></span>
            </div>
        </div>
    </div>

    <script>
        function leadTable() {
            return {
                allLeads: @json($leads),
                displayedLeads: [],
                query: '',
                
                init() {
                    // Pre-compute a searchable string for each lead to drastically improve performance
                    this.allLeads = this.allLeads.map(lead => {
                        lead._searchString = Object.values(lead).join(' ').toLowerCase();
                        return lead;
                    });
                    this.updateDisplay();
                },
                
                updateDisplay() {
                    if (this.query.trim() === '') {
                        this.displayedLeads = this.allLeads.slice(0, 10);
                        return;
                    }
                    
                    const searchTerms = this.query.toLowerCase().trim().split(/\s+/);
                    
                    this.displayedLeads = this.allLeads.filter(lead => {
                        return searchTerms.every(term => this.fuzzyIncludes(lead._searchString, term));
                    }).slice(0, 10);
                },
                
                fuzzyIncludes(text, term) {
                    if (text.includes(term)) return true;
                    if (term.length <= 2) return false; // Too short for fuzzy match
                    
                    // Allow 1 character typo
                    for (let i = 0; i <= text.length - term.length; i++) {
                        let diff = 0;
                        for (let j = 0; j < term.length; j++) {
                            if (text[i + j] !== term[j]) {
                                diff++;
                            }
                            if (diff > 1) break;
                        }
                        if (diff <= 1) return true;
                    }
                    return false;
                }
            }
        }
    </script>
</body>
</html>
