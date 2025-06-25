<svg {{ $attributes }} viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
        </linearGradient>
    </defs>
    
    <!-- Background Circle -->
    <circle cx="158" cy="158" r="150" fill="url(#logoGradient)" stroke="white" stroke-width="8"/>
    
    <!-- Note Icon -->
    <g transform="translate(80, 60)">
        <!-- Paper -->
        <rect x="20" y="20" width="120" height="160" rx="8" fill="white" stroke="#e5e7eb" stroke-width="2"/>
        
        <!-- Lines -->
        <line x1="35" y1="50" x2="125" y2="50" stroke="#9ca3af" stroke-width="2"/>
        <line x1="35" y1="70" x2="110" y2="70" stroke="#9ca3af" stroke-width="2"/>
        <line x1="35" y1="90" x2="125" y2="90" stroke="#9ca3af" stroke-width="2"/>
        <line x1="35" y1="110" x2="100" y2="110" stroke="#9ca3af" stroke-width="2"/>
        
        <!-- Pen -->
        <g transform="translate(85, 130) rotate(25)">
            <rect x="0" y="0" width="30" height="4" rx="2" fill="#fbbf24"/>
            <rect x="25" y="-1" width="8" height="6" rx="1" fill="#374151"/>
            <polygon points="33,1 40,2 33,3" fill="#1f2937"/>
        </g>
    </g>
    
    <!-- GTAW Text -->
    <text x="158" y="280" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="28" font-weight="bold">GTAW</text>
</svg>
