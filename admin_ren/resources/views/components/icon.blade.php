@props(['name' => 'car'])
<svg {{ $attributes->merge(['class' => 'ui-icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($name)
@case('dashboard')<rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="11" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><rect x="14" y="18" width="7" height="3" rx="1"/>@break
@case('plus')<path d="M12 5v14M5 12h14"/>@break
@case('image')<rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8" cy="8" r="1.5"/><path d="m3 17 5-5 4 4 4-6 5 7"/>@break
@case('catalog')<path d="M4 4h6a3 3 0 0 1 3 3v14a4 4 0 0 0-4-2H4zM13 7a3 3 0 0 1 3-3h5v15h-5a3 3 0 0 0-3 2"/>@break
@case('users')<circle cx="9" cy="8" r="3"/><path d="M3 21v-3a6 6 0 0 1 12 0v3M16 5a3 3 0 0 1 0 6M18 15a4 4 0 0 1 3 4v2"/>@break
@case('user')<circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/>@break
@case('sales')<path d="M4 19V5M4 19h16M8 14l4-4 4 2 5-7M17 5h4v4"/>@break
@case('check')<rect x="3" y="4" width="18" height="16" rx="3"/><path d="m8 12 3 3 5-6"/>@break
@case('home')<path d="m3 10 9-7 9 7v11H3zM9 21v-7h6v7"/>@break
@case('target')<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>@break
@case('menu')<path d="M4 6h16M4 12h16M4 18h16"/>@break
@case('arrow')<path d="M4 12h16m-6-6 6 6-6 6"/>@break
@case('edit')<path d="m15 5 4 4M4 20l4-1L20 7a2.8 2.8 0 0 0-4-4L4 15z"/>@break
@case('more')<circle cx="5" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/>@break
@case('chevron')<path d="m7 10 5 5 5-5"/>@break
@case('refresh')<path d="M20 7v5h-5M4 17v-5h5M6 7a7 7 0 0 1 12-1l2 3M4 15l2 3a7 7 0 0 0 12-1"/>@break
@case('qr')<rect x="3" y="3" width="6" height="6" rx="1"/><rect x="15" y="3" width="6" height="6" rx="1"/><rect x="3" y="15" width="6" height="6" rx="1"/><path d="M15 15h3v3h3v3h-6v-3M21 15v-3M12 3v3M3 12h6M12 12v6"/>@break
@case('eye')<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>@break
@case('archive')<rect x="3" y="3" width="18" height="5" rx="1"/><path d="M5 8v13h14V8M10 12h4"/>@break
@case('search')<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/>@break
@default<path d="m5 8 2-4h10l2 4 2 3v7H3v-7zM5 8h14M3 13h4m10 0h4M6 18v3m12-3v3M9 14h6"/>
@endswitch
</svg>
