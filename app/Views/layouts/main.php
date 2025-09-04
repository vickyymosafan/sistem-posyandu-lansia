<?php /* Main layout */ ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Aplikasi') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="data:,">
  
  <!-- Accessibility Enhancements -->
  <meta name="description" content="Sistem Posyandu Lansia - Kelola data dan pemeriksaan kesehatan lansia dengan mudah">
  <meta name="theme-color" content="#3B82F6">
  <style>
    /* Finalized Design System - Color Scheme & Typography */
    :root {
      /* Spacing Scale */
      --spacing-xs: 0.25rem;    /* 4px */
      --spacing-sm: 0.5rem;     /* 8px */
      --spacing-md: 1rem;       /* 16px */
      --spacing-lg: 1.5rem;     /* 24px */
      --spacing-xl: 2rem;       /* 32px */
      --spacing-2xl: 3rem;      /* 48px */
      
      /* Border Radius Scale */
      --radius-sm: 0.5rem;      /* 8px */
      --radius-md: 0.75rem;     /* 12px */
      --radius-lg: 1rem;        /* 16px */
      --radius-xl: 1.25rem;     /* 20px */
      
      /* Finalized Color Palette - Primary Colors */
      --color-primary: #3B82F6;
      --color-primary-hover: #2563EB;
      --color-primary-active: #1D4ED8;
      --color-primary-light: #DBEAFE;
      --color-primary-dark: #1E40AF;
      
      /* Success Colors */
      --color-success: #10B981;
      --color-success-hover: #059669;
      --color-success-active: #047857;
      --color-success-light: #D1FAE5;
      --color-success-dark: #065F46;
      
      /* Danger/Error Colors */
      --color-danger: #EF4444;
      --color-danger-hover: #DC2626;
      --color-danger-active: #B91C1C;
      --color-danger-light: #FEE2E2;
      --color-danger-dark: #991B1B;
      
      /* Warning Colors */
      --color-warning: #F59E0B;
      --color-warning-hover: #D97706;
      --color-warning-active: #B45309;
      --color-warning-light: #FEF3C7;
      --color-warning-dark: #92400E;
      
      /* Info/Purple Colors */
      --color-info: #8B5CF6;
      --color-info-hover: #7C3AED;
      --color-info-active: #6D28D9;
      --color-info-light: #EDE9FE;
      --color-info-dark: #5B21B6;
      
      /* Neutral Gray Scale */
      --color-gray-50: #F9FAFB;
      --color-gray-100: #F3F4F6;
      --color-gray-200: #E5E7EB;
      --color-gray-300: #D1D5DB;
      --color-gray-400: #9CA3AF;
      --color-gray-500: #6B7280;
      --color-gray-600: #4B5563;
      --color-gray-700: #374151;
      --color-gray-800: #1F2937;
      --color-gray-900: #111827;
      
      /* Typography Scale */
      --font-size-xs: 0.75rem;     /* 12px */
      --font-size-sm: 0.875rem;    /* 14px */
      --font-size-base: 1rem;      /* 16px */
      --font-size-lg: 1.125rem;    /* 18px */
      --font-size-xl: 1.25rem;     /* 20px */
      --font-size-2xl: 1.5rem;     /* 24px */
      --font-size-3xl: 1.875rem;   /* 30px */
      --font-size-4xl: 2.25rem;    /* 36px */
      
      /* Line Heights */
      --line-height-tight: 1.25;
      --line-height-normal: 1.5;
      --line-height-relaxed: 1.625;
      
      /* Font Weights */
      --font-weight-normal: 400;
      --font-weight-medium: 500;
      --font-weight-semibold: 600;
      --font-weight-bold: 700;
      
      /* Shadow Scale */
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-base: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Typography System - Finalized Hierarchy */
    body {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-feature-settings: 'kern' 1;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      font-size: var(--font-size-base);
      line-height: var(--line-height-normal);
      color: var(--color-gray-900);
    }
    
    /* Heading Typography Hierarchy */
    h1, .text-h1 {
      font-size: var(--font-size-4xl);
      font-weight: var(--font-weight-bold);
      line-height: var(--line-height-tight);
      color: var(--color-gray-900);
      letter-spacing: -0.025em;
    }
    
    h2, .text-h2 {
      font-size: var(--font-size-3xl);
      font-weight: var(--font-weight-bold);
      line-height: var(--line-height-tight);
      color: var(--color-gray-900);
      letter-spacing: -0.025em;
    }
    
    h3, .text-h3 {
      font-size: var(--font-size-2xl);
      font-weight: var(--font-weight-semibold);
      line-height: var(--line-height-tight);
      color: var(--color-gray-900);
    }
    
    h4, .text-h4 {
      font-size: var(--font-size-xl);
      font-weight: var(--font-weight-semibold);
      line-height: var(--line-height-tight);
      color: var(--color-gray-900);
    }
    
    h5, .text-h5 {
      font-size: var(--font-size-lg);
      font-weight: var(--font-weight-semibold);
      line-height: var(--line-height-normal);
      color: var(--color-gray-900);
    }
    
    h6, .text-h6 {
      font-size: var(--font-size-base);
      font-weight: var(--font-weight-semibold);
      line-height: var(--line-height-normal);
      color: var(--color-gray-900);
    }
    
    /* Body Text Hierarchy */
    .text-lead {
      font-size: var(--font-size-lg);
      font-weight: var(--font-weight-normal);
      line-height: var(--line-height-relaxed);
      color: var(--color-gray-700);
    }
    
    .text-body {
      font-size: var(--font-size-base);
      font-weight: var(--font-weight-normal);
      line-height: var(--line-height-normal);
      color: var(--color-gray-700);
    }
    
    .text-small {
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-normal);
      line-height: var(--line-height-normal);
      color: var(--color-gray-600);
    }
    
    .text-xs {
      font-size: var(--font-size-xs);
      font-weight: var(--font-weight-normal);
      line-height: var(--line-height-normal);
      color: var(--color-gray-500);
    }
    
    /* Text Color Utilities with Proper Contrast */
    .text-primary { color: var(--color-primary); }
    .text-success { color: var(--color-success); }
    .text-danger { color: var(--color-danger); }
    .text-warning { color: var(--color-warning-dark); } /* Darker for better contrast */
    .text-info { color: var(--color-info); }
    
    .text-muted { color: var(--color-gray-500); }
    .text-secondary { color: var(--color-gray-600); }
    
    /* Link Styling with Proper Contrast */
    a {
      color: var(--color-primary);
      text-decoration: none;
      transition: color 150ms ease-in-out;
    }
    
    a:hover {
      color: var(--color-primary-hover);
      text-decoration: underline;
    }

    /* Preserve readable text color on dark buttons/active nav links */
    a.text-white:hover { color: #ffffff; }
    a.bg-blue-600:hover,
    a.bg-green-600:hover,
    a.bg-red-600:hover,
    a.bg-indigo-600:hover { color: #ffffff; }
    
    a:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 2px;
      border-radius: 2px;
    }
    
    /* Enhanced Focus Styles for Accessibility */
    *:focus {
      outline: none;
    }
    
    *:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 2px;
      border-radius: 4px;
    }
    
    button:focus-visible,
    a:focus-visible,
    input:focus-visible,
    select:focus-visible,
    textarea:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 2px;
      box-shadow: 0 0 0 4px var(--color-primary-light);
    }
    
    /* High contrast focus for better visibility */
    @media (prefers-contrast: high) {
      *:focus-visible {
        outline: 3px solid var(--color-primary-dark);
        outline-offset: 3px;
      }
    }
    
    
    
    /* Screen reader only content */
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
    
    /* Focus trap for modal/menu states */
    .focus-trap {
      position: relative;
    }
    
    .focus-trap:before,
    .focus-trap:after {
      content: '';
      position: absolute;
      width: 1px;
      height: 1px;
      opacity: 0;
      pointer-events: none;
    }
    
    /* Enhanced card hover effects */
    .card-hover {
      transition: all 150ms ease-in-out;
      transform: translateY(0);
    }
    
    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    /* Smooth icon transitions */
    .icon-transition {
      transition: transform 150ms ease-in-out;
    }
    
    /* Finalized Shadow System */
    .shadow-subtle {
      box-shadow: var(--shadow-sm);
    }
    
    .shadow-card {
      box-shadow: var(--shadow-base);
    }
    
    .shadow-card-hover {
      box-shadow: var(--shadow-md);
    }
    
    .shadow-elevated {
      box-shadow: var(--shadow-lg);
    }
    
    .shadow-floating {
      box-shadow: var(--shadow-xl);
    }
    
    /* Card Components with Finalized Styling */
    .card {
      background-color: white;
      border: 1px solid var(--color-gray-200);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-base);
      transition: all 150ms ease-in-out;
    }
    
    .card-hover:hover {
      box-shadow: var(--shadow-md);
      border-color: var(--color-gray-300);
    }
    
    .card-interactive {
      cursor: pointer;
      transition: all 150ms ease-in-out;
    }
    
    .card-interactive:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
      border-color: var(--color-primary-light);
    }
    
    .card-interactive:active {
      transform: translateY(0);
      box-shadow: var(--shadow-base);
    }
    
    /* Enhanced Form Components with Micro-interactions */
    .form-input {
      width: 100%;
      padding: var(--spacing-md) var(--spacing-lg);
      border: 1px solid var(--color-gray-300);
      border-radius: var(--radius-md);
      background-color: white;
      color: var(--color-gray-900);
      font-size: var(--font-size-sm);
      line-height: var(--line-height-tight);
      transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
      transform: translateY(0);
    }
    
    .form-input::placeholder {
      color: var(--color-gray-500);
    }
    
    .form-input:hover:not(:disabled):not(:focus) {
      border-color: var(--color-gray-400);
      transform: translateY(-1px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .form-input:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 0 3px var(--color-primary-light), 0 2px 8px rgba(59, 130, 246, 0.15);
      transform: translateY(-1px);
    }
    
    /* Input Loading State */
    .form-input-loading {
      position: relative;
      background-image: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      background-size: 200% 100%;
      animation: inputShimmer 1.5s ease-in-out infinite;
    }
    
    @keyframes inputShimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
    
    /* Input Success State */
    .form-input-success {
      border-color: var(--color-success);
      background-color: var(--color-success-light);
      animation: successBounce 0.3s ease-out;
    }
    
    /* Input Error State with Enhanced Animation */
    .form-input-error {
      border-color: var(--color-danger);
      background-color: var(--color-danger-light);
      animation: shake 0.5s ease-in-out;
    }
    
    .form-input:disabled {
      background-color: var(--color-gray-50);
      color: var(--color-gray-500);
      border-color: var(--color-gray-200);
      cursor: not-allowed;
    }
    
    .form-input.error {
      border-color: var(--color-danger);
      background-color: var(--color-danger-light);
    }
    
    .form-input.error:focus {
      border-color: var(--color-danger);
      box-shadow: 0 0 0 3px var(--color-danger-light);
    }
    
    .form-input.success {
      border-color: var(--color-success);
      background-color: var(--color-success-light);
    }
    
    .form-input.success:focus {
      border-color: var(--color-success);
      box-shadow: 0 0 0 3px var(--color-success-light);
    }
    
    .form-label {
      display: block;
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-medium);
      color: var(--color-gray-700);
      margin-bottom: var(--spacing-sm);
      line-height: var(--line-height-tight);
    }
    
    .form-label.required::after {
      content: ' *';
      color: var(--color-danger);
      font-weight: var(--font-weight-normal);
    }
    
    .form-error {
      display: flex;
      align-items: flex-start;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-sm);
      font-size: var(--font-size-sm);
      color: var(--color-danger);
      line-height: var(--line-height-tight);
    }
    
    .form-success {
      display: flex;
      align-items: flex-start;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-sm);
      font-size: var(--font-size-sm);
      color: var(--color-success);
      line-height: var(--line-height-tight);
    }
    
    .form-help {
      margin-top: var(--spacing-xs);
      font-size: var(--font-size-sm);
      color: var(--color-gray-500);
      line-height: var(--line-height-normal);
    }
    
    .form-warning {
      display: flex;
      align-items: flex-start;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-sm);
      font-size: var(--font-size-sm);
      color: var(--color-warning-dark);
      line-height: var(--line-height-tight);
    }
    
    .form-info {
      display: flex;
      align-items: flex-start;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-sm);
      font-size: var(--font-size-sm);
      color: var(--color-info);
      line-height: var(--line-height-tight);
    }
    
    /* Finalized Button Components with Consistent Color Scheme */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: var(--spacing-md) var(--spacing-lg);
      border-radius: var(--radius-md);
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-semibold);
      line-height: var(--line-height-tight);
      min-height: 2.75rem;
      border: 1px solid transparent;
      cursor: pointer;
      transition: all 150ms ease-in-out;
      text-decoration: none;
    }
    
    .btn:focus-visible {
      outline: 2px solid transparent;
      outline-offset: 2px;
      box-shadow: 0 0 0 2px var(--color-primary);
    }
    
    .btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none !important;
    }
    
    .btn-primary {
      background-color: var(--color-primary);
      color: white;
      box-shadow: var(--shadow-sm);
    }
    
    .btn:hover {
      text-decoration: none;
    }

    .btn-primary:hover:not(:disabled) {
      background-color: var(--color-primary-hover);
      color: #ffffff; /* keep text visible on hover */
      box-shadow: var(--shadow-md);
    }
    
    .btn-primary:active:not(:disabled) {
      background-color: var(--color-primary-active);
      transform: scale(0.98);
    }
    
    .btn-success {
      background-color: var(--color-success);
      color: white;
      box-shadow: var(--shadow-sm);
    }
    
    .btn-success:hover:not(:disabled) {
      background-color: var(--color-success-hover);
      box-shadow: var(--shadow-md);
    }
    
    .btn-success:active:not(:disabled) {
      background-color: var(--color-success-active);
      transform: scale(0.98);
    }
    
    .btn-danger {
      background-color: var(--color-danger);
      color: white;
      box-shadow: var(--shadow-sm);
    }
    
    .btn-danger:hover:not(:disabled) {
      background-color: var(--color-danger-hover);
      box-shadow: var(--shadow-md);
    }
    
    .btn-danger:active:not(:disabled) {
      background-color: var(--color-danger-active);
      transform: scale(0.98);
    }
    
    .btn-warning {
      background-color: var(--color-warning);
      color: white;
      box-shadow: var(--shadow-sm);
    }
    
    .btn-warning:hover:not(:disabled) {
      background-color: var(--color-warning-hover);
      box-shadow: var(--shadow-md);
    }
    
    .btn-warning:active:not(:disabled) {
      background-color: var(--color-warning-active);
      transform: scale(0.98);
    }
    
    .btn-info {
      background-color: var(--color-info);
      color: white;
      box-shadow: var(--shadow-sm);
    }
    
    .btn-info:hover:not(:disabled) {
      background-color: var(--color-info-hover);
      box-shadow: var(--shadow-md);
    }
    
    .btn-info:active:not(:disabled) {
      background-color: var(--color-info-active);
      transform: scale(0.98);
    }
    
    .btn-secondary {
      background-color: var(--color-gray-100);
      color: var(--color-gray-700);
      border-color: var(--color-gray-200);
      box-shadow: var(--shadow-sm);
    }
    
    .btn-secondary:hover:not(:disabled) {
      background-color: var(--color-gray-200);
      color: var(--color-gray-800);
      box-shadow: var(--shadow-md);
    }
    
    .btn-secondary:active:not(:disabled) {
      background-color: var(--color-gray-300);
      transform: scale(0.98);
    }
    
    .btn-outline {
      background-color: transparent;
      color: var(--color-gray-700);
      border-color: var(--color-gray-300);
    }
    
    .btn-outline:hover:not(:disabled) {
      background-color: var(--color-gray-50);
      border-color: var(--color-gray-400);
      color: var(--color-gray-800);
    }
    
    .btn-outline:active:not(:disabled) {
      background-color: var(--color-gray-100);
      transform: scale(0.98);
    }
    
    .btn-outline-primary {
      background-color: transparent;
      color: var(--color-primary);
      border-color: var(--color-primary);
    }
    
    .btn-outline-primary:hover:not(:disabled) {
      background-color: var(--color-primary-light);
      color: var(--color-primary-dark);
    }
    
    .btn-outline-primary:active:not(:disabled) {
      background-color: var(--color-primary);
      color: white;
      transform: scale(0.98);
    }
    
    /* Enhanced Loading States for Buttons */
    .btn-loading {
      position: relative;
      pointer-events: none;
      overflow: hidden;
    }
    
    .btn-loading .btn-text {
      opacity: 0;
      transform: translateY(-2px);
      transition: all 150ms ease-in-out;
    }
    
    .btn-loading .btn-loading-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      opacity: 1;
      animation: fadeIn 150ms ease-in-out;
    }
    
    .btn-loading-spinner {
      width: 1rem;
      height: 1rem;
      border: 2px solid transparent;
      border-top-color: currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    /* Button Micro-interactions */
    .btn-micro {
      transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
      transform: translateY(0);
    }
    
    .btn-micro:hover:not(:disabled) {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-micro:active:not(:disabled) {
      transform: translateY(0);
      transition-duration: 75ms;
    }
    
    .btn-micro:focus-visible {
      transform: translateY(-1px);
      box-shadow: 0 0 0 3px var(--color-primary-light), 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Success State Animation */
    .btn-success-state {
      background-color: var(--color-success) !important;
      animation: successBounce 0.6s ease-out;
    }
    
    .btn-success-state .btn-loading-content {
      animation: fadeIn 300ms ease-in-out;
    }
    
    /* Error State Animation */
    .btn-error-state {
      animation: shake 0.5s ease-in-out;
    }
    
    /* Form Group Styling */
    .form-group {
      @apply space-y-2;
    }
    
    .form-group-inline {
      @apply flex items-center gap-4;
    }
    
    /* Finalized Table Styling with Consistent Colors */
    .table-modern {
      min-width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-base);
    }
    
    .table-modern thead {
      background-color: var(--color-gray-50);
    }
    
    .table-modern th {
      padding: var(--spacing-lg) var(--spacing-xl);
      text-align: left;
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-semibold);
      color: var(--color-gray-900);
      letter-spacing: 0.025em;
      border-bottom: 1px solid var(--color-gray-200);
    }
    
    .table-modern tbody {
      background-color: white;
    }
    
    .table-modern td {
      padding: var(--spacing-lg) var(--spacing-xl);
      font-size: var(--font-size-sm);
      color: var(--color-gray-900);
      border-bottom: 1px solid var(--color-gray-100);
      vertical-align: top;
    }
    
    .table-modern tbody tr:nth-child(even) {
      background-color: var(--color-gray-50);
    }
    
    .table-modern tbody tr:hover {
      background-color: var(--color-primary-light);
    }
    
    .table-modern tbody tr:last-child td {
      border-bottom: none;
    }
    
    /* Table Action Buttons with Consistent Styling */
    .table-action-btn {
      display: inline-flex;
      align-items: center;
      padding: var(--spacing-xs) var(--spacing-md);
      font-size: var(--font-size-xs);
      font-weight: var(--font-weight-medium);
      border-radius: var(--radius-sm);
      transition: all 150ms ease-in-out;
      text-decoration: none;
      border: 1px solid transparent;
    }
    
    .table-action-btn-primary {
      background-color: var(--color-primary);
      color: white;
    }
    
    .table-action-btn-primary:hover {
      background-color: var(--color-primary-hover);
      color: white;
    }
    
    .table-action-btn-success {
      background-color: var(--color-success);
      color: white;
    }
    
    .table-action-btn-success:hover {
      background-color: var(--color-success-hover);
      color: white;
    }
    
    .table-action-btn-secondary {
      background-color: var(--color-gray-100);
      color: var(--color-gray-700);
      border-color: var(--color-gray-200);
    }
    
    .table-action-btn-secondary:hover {
      background-color: var(--color-gray-200);
      color: var(--color-gray-800);
    }
    
    .table-action-btn-danger {
      background-color: var(--color-danger);
      color: white;
    }
    
    .table-action-btn-danger:hover {
      background-color: var(--color-danger-hover);
      color: white;
    }
    
    /* Action Button Styling for Tables */
    .table-action-btn {
      @apply inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-150 shadow-sm;
    }
    
    .table-action-btn-primary {
      @apply bg-blue-600 text-white hover:bg-blue-700;
    }
    
    .table-action-btn-success {
      @apply bg-green-600 text-white hover:bg-green-700;
    }
    
    .table-action-btn-secondary {
      @apply bg-gray-100 text-gray-700 hover:bg-gray-200;
    }
    
    /* Mobile Card Styling for Responsive Tables */
    .mobile-card {
      @apply p-4 border-b border-gray-200 hover:bg-gray-50/50 transition-colors duration-150;
    }
    
    .mobile-card:last-child {
      @apply border-b-0;
    }
    
    /* Finalized Radio and Checkbox Styling */
    .form-radio,
    .form-checkbox {
      width: 1rem;
      height: 1rem;
      color: var(--color-primary);
      border: 1px solid var(--color-gray-300);
      background-color: white;
      transition: all 150ms ease-in-out;
    }
    
    .form-radio:focus,
    .form-checkbox:focus {
      outline: none;
      box-shadow: 0 0 0 3px var(--color-primary-light);
    }
    
    .form-radio:checked,
    .form-checkbox:checked {
      background-color: var(--color-primary);
      border-color: var(--color-primary);
    }
    
    .form-radio:hover:not(:disabled),
    .form-checkbox:hover:not(:disabled) {
      border-color: var(--color-gray-400);
    }
    
    .form-radio:disabled,
    .form-checkbox:disabled {
      background-color: var(--color-gray-50);
      border-color: var(--color-gray-200);
      cursor: not-allowed;
    }
    
    .form-radio {
      border-radius: 50%;
    }
    
    .form-checkbox {
      border-radius: var(--radius-sm);
    }
    
    /* Form Group Styling */
    .form-group {
      margin-bottom: var(--spacing-lg);
    }
    
    .form-group-inline {
      display: flex;
      align-items: center;
      gap: var(--spacing-lg);
      flex-wrap: wrap;
    }
    
    .form-group-inline label {
      margin-bottom: 0;
    }
    
    /* Finalized Select Styling */
    .form-select {
      width: 100%;
      padding: var(--spacing-md) 2.5rem var(--spacing-md) var(--spacing-lg);
      border: 1px solid var(--color-gray-300);
      border-radius: var(--radius-md);
      background-color: white;
      color: var(--color-gray-900);
      font-size: var(--font-size-sm);
      line-height: var(--line-height-tight);
      appearance: none;
      transition: all 150ms ease-in-out;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
      background-position: right var(--spacing-md) center;
      background-repeat: no-repeat;
      background-size: 1.25em 1.25em;
    }
    
    .form-select:hover:not(:disabled) {
      border-color: var(--color-gray-400);
    }
    
    .form-select:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 0 3px var(--color-primary-light);
    }
    
    .form-select:disabled {
      background-color: var(--color-gray-50);
      color: var(--color-gray-500);
      border-color: var(--color-gray-200);
      cursor: not-allowed;
    }
    
    .form-select.error {
      border-color: var(--color-danger);
      background-color: var(--color-danger-light);
    }
    
    .form-select.error:focus {
      border-color: var(--color-danger);
      box-shadow: 0 0 0 3px var(--color-danger-light);
    }
    
    /* Finalized Textarea Styling */
    .form-textarea {
      width: 100%;
      padding: var(--spacing-md) var(--spacing-lg);
      border: 1px solid var(--color-gray-300);
      border-radius: var(--radius-md);
      background-color: white;
      color: var(--color-gray-900);
      font-size: var(--font-size-sm);
      line-height: var(--line-height-normal);
      resize: vertical;
      min-height: 5rem;
      transition: all 150ms ease-in-out;
      font-family: inherit;
    }
    
    .form-textarea::placeholder {
      color: var(--color-gray-500);
    }
    
    .form-textarea:hover:not(:disabled) {
      border-color: var(--color-gray-400);
    }
    
    .form-textarea:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 0 3px var(--color-primary-light);
    }
    
    .form-textarea:disabled {
      background-color: var(--color-gray-50);
      color: var(--color-gray-500);
      border-color: var(--color-gray-200);
      cursor: not-allowed;
      resize: none;
    }
    
    .form-textarea.error {
      border-color: var(--color-danger);
      background-color: var(--color-danger-light);
    }
    
    .form-textarea.error:focus {
      border-color: var(--color-danger);
      box-shadow: 0 0 0 3px var(--color-danger-light);
    }
    
    /* Status Badges with Finalized Color Scheme */
    .badge {
      display: inline-flex;
      align-items: center;
      padding: var(--spacing-xs) var(--spacing-md);
      font-size: var(--font-size-xs);
      font-weight: var(--font-weight-medium);
      border-radius: var(--radius-lg);
      line-height: var(--line-height-tight);
    }
    
    .badge-primary {
      background-color: var(--color-primary-light);
      color: var(--color-primary-dark);
    }
    
    .badge-success {
      background-color: var(--color-success-light);
      color: var(--color-success-dark);
    }
    
    .badge-danger {
      background-color: var(--color-danger-light);
      color: var(--color-danger-dark);
    }
    
    .badge-warning {
      background-color: var(--color-warning-light);
      color: var(--color-warning-dark);
    }
    
    .badge-info {
      background-color: var(--color-info-light);
      color: var(--color-info-dark);
    }
    
    .badge-secondary {
      background-color: var(--color-gray-100);
      color: var(--color-gray-700);
    }
    
    /* Alert/Notification Components */
    .alert {
      padding: var(--spacing-lg);
      border-radius: var(--radius-md);
      border: 1px solid transparent;
      margin-bottom: var(--spacing-lg);
    }
    
    .alert-primary {
      background-color: var(--color-primary-light);
      border-color: var(--color-primary);
      color: var(--color-primary-dark);
    }
    
    .alert-success {
      background-color: var(--color-success-light);
      border-color: var(--color-success);
      color: var(--color-success-dark);
    }
    
    .alert-danger {
      background-color: var(--color-danger-light);
      border-color: var(--color-danger);
      color: var(--color-danger-dark);
    }
    
    .alert-warning {
      background-color: var(--color-warning-light);
      border-color: var(--color-warning);
      color: var(--color-warning-dark);
    }
    
    .alert-info {
      background-color: var(--color-info-light);
      border-color: var(--color-info);
      color: var(--color-info-dark);
    }
    
    /* Enhanced Animation Utilities for Loading States and Micro-interactions */
    .animate-fade-in {
      animation: fadeIn 0.2s ease-in-out;
    }
    
    .animate-slide-up {
      animation: slideUp 0.3s ease-out;
    }
    
    .animate-bounce-in {
      animation: bounceIn 0.4s ease-out;
    }
    
    .animate-pulse-subtle {
      animation: pulseSubtle 2s ease-in-out infinite;
    }
    
    .animate-shake {
      animation: shake 0.5s ease-in-out;
    }
    
    .animate-success-bounce {
      animation: successBounce 0.6s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-4px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(1rem); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes bounceIn {
      0% { opacity: 0; transform: scale(0.3); }
      50% { opacity: 1; transform: scale(1.05); }
      70% { transform: scale(0.9); }
      100% { opacity: 1; transform: scale(1); }
    }
    
    @keyframes pulseSubtle {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
      20%, 40%, 60%, 80% { transform: translateX(2px); }
    }
    
    @keyframes successBounce {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    /* Loading Spinner Animation */
    .loading-spinner {
      display: inline-block;
      width: 1rem;
      height: 1rem;
      border: 2px solid transparent;
      border-top-color: currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    .loading-dots {
      display: inline-flex;
      gap: 2px;
    }
    
    .loading-dots span {
      width: 4px;
      height: 4px;
      background-color: currentColor;
      border-radius: 50%;
      animation: loadingDots 1.4s ease-in-out infinite both;
    }
    
    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }
    .loading-dots span:nth-child(3) { animation-delay: 0s; }
    
    @keyframes loadingDots {
      0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
      40% { transform: scale(1.2); opacity: 1; }
    }
    
    /* Enhanced Form Feedback Styling */
    .form-feedback-card {
      transition: all 0.2s ease-in-out;
      transform: translateY(0);
    }
    
    .form-feedback-card.show {
      transform: translateY(0);
      opacity: 1;
    }
    
    /* Responsive Design Improvements */
    @media (max-width: 768px) {
      /* Mobile Typography Adjustments */
      h1, .text-h1 {
        font-size: var(--font-size-3xl);
      }
      
      h2, .text-h2 {
        font-size: var(--font-size-2xl);
      }
      
      h3, .text-h3 {
        font-size: var(--font-size-xl);
      }
      
      /* Mobile Form Improvements */
      .form-input,
      .form-select,
      .form-textarea {
        font-size: 16px; /* Prevents zoom on iOS */
        padding: var(--spacing-lg);
      }
      
      /* Mobile Button Improvements */
      .btn {
        min-height: 3rem; /* Larger touch targets */
        padding: var(--spacing-lg) var(--spacing-xl);
        font-size: var(--font-size-base);
      }
      
      /* Mobile Table Improvements */
      .table-modern {
        font-size: var(--font-size-xs);
      }
      
      .table-modern th,
      .table-modern td {
        padding: var(--spacing-md);
      }
      
      /* Mobile Card Improvements */
      .card {
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-lg);
      }
      
      /* Mobile Spacing Adjustments */
      .form-group {
        margin-bottom: var(--spacing-xl);
      }
      
      .form-group-inline {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--spacing-md);
      }
    }
    
    @media (max-width: 480px) {
      /* Extra small mobile adjustments */
      .btn {
        width: 100%;
        justify-content: center;
      }
      /* Exception: keep search submit button compact */
      #searchBtn {
        width: auto;
      }
      
      .table-action-btn {
        font-size: var(--font-size-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
      }
    }
    
    /* High contrast mode support */
    @media (prefers-contrast: high) {
      .form-input,
      .form-select,
      .form-textarea {
        border-width: 2px;
      }
      
      .btn {
        border-width: 2px;
        border-style: solid;
      }
      
      .btn-primary {
        border-color: var(--color-primary-dark);
      }
      
      .btn-success {
        border-color: var(--color-success-dark);
      }
      
      .btn-danger {
        border-color: var(--color-danger-dark);
      }
    }
    
    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
      *,
      *::before,
      *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }
    
    /* Utility Classes for Consistent Spacing and Layout */
    .space-y-xs > * + * { margin-top: var(--spacing-xs); }
    .space-y-sm > * + * { margin-top: var(--spacing-sm); }
    .space-y-md > * + * { margin-top: var(--spacing-md); }
    .space-y-lg > * + * { margin-top: var(--spacing-lg); }
    .space-y-xl > * + * { margin-top: var(--spacing-xl); }
    .space-y-2xl > * + * { margin-top: var(--spacing-2xl); }
    
    .space-x-xs > * + * { margin-left: var(--spacing-xs); }
    .space-x-sm > * + * { margin-left: var(--spacing-sm); }
    .space-x-md > * + * { margin-left: var(--spacing-md); }
    .space-x-lg > * + * { margin-left: var(--spacing-lg); }
    .space-x-xl > * + * { margin-left: var(--spacing-xl); }
    
    .gap-xs { gap: var(--spacing-xs); }
    .gap-sm { gap: var(--spacing-sm); }
    .gap-md { gap: var(--spacing-md); }
    .gap-lg { gap: var(--spacing-lg); }
    .gap-xl { gap: var(--spacing-xl); }
    
    /* Background Color Utilities */
    .bg-primary { background-color: var(--color-primary); }
    .bg-primary-light { background-color: var(--color-primary-light); }
    .bg-success { background-color: var(--color-success); }
    .bg-success-light { background-color: var(--color-success-light); }
    .bg-danger { background-color: var(--color-danger); }
    .bg-danger-light { background-color: var(--color-danger-light); }
    .bg-warning { background-color: var(--color-warning); }
    .bg-warning-light { background-color: var(--color-warning-light); }
    .bg-info { background-color: var(--color-info); }
    .bg-info-light { background-color: var(--color-info-light); }
    
    .bg-gray-50 { background-color: var(--color-gray-50); }
    .bg-gray-100 { background-color: var(--color-gray-100); }
    .bg-gray-200 { background-color: var(--color-gray-200); }
    
    /* Border Color Utilities */
    .border-primary { border-color: var(--color-primary); }
    .border-success { border-color: var(--color-success); }
    .border-danger { border-color: var(--color-danger); }
    .border-warning { border-color: var(--color-warning); }
    .border-info { border-color: var(--color-info); }
    
    .border-gray-100 { border-color: var(--color-gray-100); }
    .border-gray-200 { border-color: var(--color-gray-200); }
    .border-gray-300 { border-color: var(--color-gray-300); }
    
    /* Border Radius Utilities */
    .rounded-sm { border-radius: var(--radius-sm); }
    .rounded-md { border-radius: var(--radius-md); }
    .rounded-lg { border-radius: var(--radius-lg); }
    .rounded-xl { border-radius: var(--radius-xl); }
    
    /* Flexbox Utilities */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .flex-wrap { flex-wrap: wrap; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .items-end { align-items: flex-end; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .justify-start { justify-content: flex-start; }
    .justify-end { justify-content: flex-end; }
    
    /* Grid Utilities */
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    
    @media (min-width: 768px) {
      .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .md\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }
    
    @media (min-width: 1024px) {
      .lg\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .lg\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .lg\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }
    
    /* Dark mode preparation (for future implementation) */
    @media (prefers-color-scheme: dark) {
      /* Dark mode variables would go here */
      /* Currently maintaining light mode only as per requirements */
    }
  </style>
  
  <!-- Enhanced Loading States and Micro-interactions Library -->
  <script>
    // Enhanced Loading States and Micro-interactions System
    class LoadingStateManager {
      constructor() {
        this.activeLoadings = new Set();
        this.init();
      }
      
      init() {
        // Auto-enhance all buttons with micro-interactions
        document.addEventListener('DOMContentLoaded', () => {
          this.enhanceButtons();
          this.enhanceInputs();
          this.setupFormSubmissionHandlers();
        });
      }
      
      enhanceButtons() {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(btn => {
          if (!btn.classList.contains('btn-micro')) {
            btn.classList.add('btn-micro');
          }
          
          // Add ripple effect on click
          btn.addEventListener('click', (e) => {
            this.createRipple(e, btn);
          });
        });
      }
      
      enhanceInputs() {
        const inputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
        inputs.forEach(input => {
          // Add subtle focus animations
          input.addEventListener('focus', () => {
            input.parentNode.classList.add('input-focused');
          });
          
          input.addEventListener('blur', () => {
            input.parentNode.classList.remove('input-focused');
          });
          
          // Add typing feedback
          input.addEventListener('input', () => {
            this.handleInputFeedback(input);
          });
        });
      }
      
      setupFormSubmissionHandlers() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
          form.addEventListener('submit', (e) => {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
              this.setButtonLoading(submitBtn);
            }
          });
        });
      }
      
      createRipple(event, button) {
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
          position: absolute;
          width: ${size}px;
          height: ${size}px;
          left: ${x}px;
          top: ${y}px;
          background: rgba(255, 255, 255, 0.3);
          border-radius: 50%;
          transform: scale(0);
          animation: ripple 0.6s ease-out;
          pointer-events: none;
          z-index: 1;
        `;
        
        // Add ripple keyframes if not exists
        if (!document.querySelector('#ripple-styles')) {
          const style = document.createElement('style');
          style.id = 'ripple-styles';
          style.textContent = `
            @keyframes ripple {
              to { transform: scale(2); opacity: 0; }
            }
            .input-focused { transform: scale(1.01); }
          `;
          document.head.appendChild(style);
        }
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        setTimeout(() => {
          if (button.contains(ripple)) {
            button.removeChild(ripple);
          }
        }, 600);
      }
      
      handleInputFeedback(input) {
        // Remove any existing feedback classes
        input.classList.remove('form-input-success', 'form-input-error');
        
        // Add subtle typing animation
        input.style.transform = 'scale(1.005)';
        setTimeout(() => {
          input.style.transform = '';
        }, 100);
      }
      
      setButtonLoading(button, loadingText = 'Memproses...') {
        if (this.activeLoadings.has(button)) return;
        
        this.activeLoadings.add(button);
        button.disabled = true;
        
        // Store original content
        const originalContent = button.innerHTML;
        button.setAttribute('data-original-content', originalContent);
        
        // Create loading content
        const loadingContent = `
          <span class="btn-loading-content">
            <span class="btn-loading-spinner"></span>
            <span>${loadingText}</span>
          </span>
          <span class="btn-text">${originalContent}</span>
        `;
        
        button.innerHTML = loadingContent;
        button.classList.add('btn-loading');
        
        // Add haptic feedback if available
        this.haptic(5);
      }
      
      setButtonSuccess(button, successText = 'Berhasil!', duration = 2000) {
        if (!this.activeLoadings.has(button)) return;
        
        button.classList.remove('btn-loading');
        button.classList.add('btn-success-state');
        
        const successContent = `
          <span class="btn-loading-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg>
            <span>${successText}</span>
          </span>
        `;
        
        button.innerHTML = successContent;
        this.haptic(10);
        
        setTimeout(() => {
          this.resetButton(button);
        }, duration);
      }
      
      setButtonError(button, errorText = 'Gagal!', duration = 3000) {
        if (!this.activeLoadings.has(button)) return;
        
        button.classList.remove('btn-loading');
        button.classList.add('btn-error-state');
        button.disabled = false;
        
        const errorContent = `
          <span class="btn-loading-content">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            <span>${errorText}</span>
          </span>
        `;
        
        button.innerHTML = errorContent;
        this.haptic(20);
        
        setTimeout(() => {
          this.resetButton(button);
        }, duration);
      }
      
      resetButton(button) {
        this.activeLoadings.delete(button);
        button.disabled = false;
        button.classList.remove('btn-loading', 'btn-success-state', 'btn-error-state');
        
        const originalContent = button.getAttribute('data-original-content');
        if (originalContent) {
          button.innerHTML = originalContent;
          button.removeAttribute('data-original-content');
        }
      }
      
      setInputLoading(input, duration = 1000) {
        input.classList.add('form-input-loading');
        input.disabled = true;
        
        setTimeout(() => {
          input.classList.remove('form-input-loading');
          input.disabled = false;
        }, duration);
      }
      
      setInputSuccess(input, duration = 2000) {
        input.classList.remove('form-input-loading', 'form-input-error');
        input.classList.add('form-input-success');
        
        setTimeout(() => {
          input.classList.remove('form-input-success');
        }, duration);
      }
      
      setInputError(input, duration = 3000) {
        input.classList.remove('form-input-loading', 'form-input-success');
        input.classList.add('form-input-error');
        
        setTimeout(() => {
          input.classList.remove('form-input-error');
        }, duration);
      }
      
      // Enhanced haptic feedback
      haptic(intensity = 10) {
        if ('vibrate' in navigator) {
          navigator.vibrate(intensity);
        }
      }
      
      // Utility method for smooth transitions
      smoothTransition(element, property, from, to, duration = 300) {
        return new Promise(resolve => {
          element.style.transition = `${property} ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
          element.style[property] = from;
          
          requestAnimationFrame(() => {
            element.style[property] = to;
            setTimeout(() => {
              element.style.transition = '';
              resolve();
            }, duration);
          });
        });
      }
      
      // Show loading overlay for entire forms
      showFormLoading(form, message = 'Memproses data...') {
        const overlay = document.createElement('div');
        overlay.className = 'form-loading-overlay';
        overlay.innerHTML = `
          <div class="form-loading-content">
            <div class="loading-spinner"></div>
            <span>${message}</span>
          </div>
        `;
        
        // Add overlay styles if not exists
        if (!document.querySelector('#form-loading-styles')) {
          const style = document.createElement('style');
          style.id = 'form-loading-styles';
          style.textContent = `
            .form-loading-overlay {
              position: absolute;
              top: 0;
              left: 0;
              right: 0;
              bottom: 0;
              background: rgba(255, 255, 255, 0.9);
              display: flex;
              align-items: center;
              justify-content: center;
              z-index: 10;
              border-radius: inherit;
              backdrop-filter: blur(2px);
            }
            .form-loading-content {
              display: flex;
              flex-direction: column;
              align-items: center;
              gap: 1rem;
              color: var(--color-gray-700);
              font-weight: 500;
            }
          `;
          document.head.appendChild(style);
        }
        
        form.style.position = 'relative';
        form.appendChild(overlay);
        
        // Animate in
        overlay.style.opacity = '0';
        requestAnimationFrame(() => {
          overlay.style.transition = 'opacity 200ms ease-in-out';
          overlay.style.opacity = '1';
        });
        
        return overlay;
      }
      
      hideFormLoading(form) {
        const overlay = form.querySelector('.form-loading-overlay');
        if (overlay) {
          overlay.style.opacity = '0';
          setTimeout(() => {
            if (form.contains(overlay)) {
              form.removeChild(overlay);
            }
          }, 200);
        }
      }
    }
    
    // Initialize the loading state manager
    window.loadingManager = new LoadingStateManager();
    
    // Global helper functions for backward compatibility
    function haptic(intensity = 10) {
      if (navigator.vibrate) navigator.vibrate(intensity);
    }
    
    function setButtonLoading(button, text) {
      window.loadingManager.setButtonLoading(button, text);
    }
    
    function setButtonSuccess(button, text, duration) {
      window.loadingManager.setButtonSuccess(button, text, duration);
    }
    
    function setButtonError(button, text, duration) {
      window.loadingManager.setButtonError(button, text, duration);
    }
    
    function resetButton(button) {
      window.loadingManager.resetButton(button);
    }
  </script>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
  <?php
    $curr = strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?: '/';
    $isActive = function (string $href) use ($curr): bool {
        if ($href === '/') return $curr === '/';
        return $curr === $href || str_starts_with($curr, $href . '/');
    };
    $linkCls = function (bool $active): string {
        $base = 'inline-flex items-center px-4 py-2 rounded-lg font-medium text-sm transition-all duration-150';
        return $active ? ($base . ' bg-blue-600 text-white shadow-sm') : ($base . ' text-gray-600 hover:text-blue-600 hover:bg-blue-50');
    };
    $auth = $_SESSION['user'] ?? null;
    $isAdmin = $auth && (($auth['role'] ?? null) === 'admin');
    $isLoggedIn = (bool)$auth;
    $csrfToken = $_SESSION['csrf_token'] ?? '';
    $isAuthPage = isset($isAuthPage) && (bool)$isAuthPage;
  ?>
  
  <?php if (!$isAuthPage): ?>
  <header class="bg-white border-b border-gray-200 sticky top-0 z-20 transition-shadow duration-200" id="siteHeader" role="banner">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="/" class="flex items-center gap-3 font-semibold text-lg tracking-tight hover:opacity-80 transition-opacity duration-150 focus:opacity-80" aria-label="Posyandu Lansia - Beranda">
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-sm" aria-hidden="true">PL</span>
        <span class="text-gray-900">Posyandu Lansia</span>
      </a>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-2" role="navigation" aria-label="Navigasi utama">
        <?php if ($isLoggedIn): ?>
          <a href="/lansia" class="<?= $linkCls($isActive('/lansia')) ?>" aria-current="<?= $isActive('/lansia') ? 'page' : 'false' ?>">Data Lansia</a>
          <a href="/lansia/create" class="<?= $linkCls($isActive('/lansia/create')) ?>" aria-current="<?= $isActive('/lansia/create') ? 'page' : 'false' ?>">Pendaftaran</a>
          <a href="/find" class="<?= $linkCls($isActive('/find')) ?>" aria-current="<?= $isActive('/find') ? 'page' : 'false' ?>">Cari ID</a>
          <?php if ($isAdmin): ?>
            <a href="/petugas/create" class="<?= $linkCls($isActive('/petugas/create')) ?>" aria-current="<?= $isActive('/petugas/create') ? 'page' : 'false' ?>">Petugas Baru</a>
          <?php endif; ?>
        <?php endif; ?>
      </nav>

      <div class="hidden md:flex items-center gap-3">
        <?php if ($isLoggedIn): ?>
          <span class="text-sm text-gray-700">Halo, <strong><?= htmlspecialchars($auth['nama'] ?? 'Pengguna') ?></strong> <span class="text-xs text-gray-500">(<?= htmlspecialchars($auth['role'] ?? '-') ?>)</span></span>
          <a href="/profil" class="<?= $linkCls($isActive('/profil')) ?> gap-2" aria-current="<?= $isActive('/profil') ? 'page' : 'false' ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 0115 0" />
            </svg>
            <span>Profil</span>
          </a>
          <form method="post" action="/logout">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">
            <button type="submit" class="btn btn-secondary">Keluar</button>
          </form>
        <?php endif; ?>
      </div>

      <!-- Mobile toggle -->
      <button id="navToggle" 
              class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-gray-600 transition-all duration-150" 
              aria-expanded="false" 
              aria-controls="mobileMenu"
              aria-label="Buka menu navigasi"
              type="button">
        <span class="sr-only">Buka menu navigasi</span>
        <svg id="iconMenu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 transition-transform duration-200" aria-hidden="true">
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
        <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 hidden transition-transform duration-200" aria-hidden="true">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <!-- Mobile nav -->
    <div id="mobileMenu" class="md:hidden hidden border-t border-gray-200 bg-white overflow-hidden transition-all duration-200 ease-in-out focus-trap" style="max-height: 0;" role="region" aria-labelledby="navToggle">
      <nav class="px-4 py-4 space-y-2" role="navigation" aria-label="Navigasi mobile">
        <?php if ($isLoggedIn): ?>
          <a href="/lansia" class="<?= $linkCls($isActive('/lansia')) ?> block focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg" tabindex="-1" aria-current="<?= $isActive('/lansia') ? 'page' : 'false' ?>">Data Lansia</a>
          <a href="/lansia/create" class="<?= $linkCls($isActive('/lansia/create')) ?> block focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg" tabindex="-1" aria-current="<?= $isActive('/lansia/create') ? 'page' : 'false' ?>">Pendaftaran</a>
          <a href="/find" class="<?= $linkCls($isActive('/find')) ?> block focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg" tabindex="-1" aria-current="<?= $isActive('/find') ? 'page' : 'false' ?>">Cari ID</a>
          <?php if ($isAdmin): ?>
            <a href="/petugas/create" class="<?= $linkCls($isActive('/petugas/create')) ?> block focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg" tabindex="-1" aria-current="<?= $isActive('/petugas/create') ? 'page' : 'false' ?>">Petugas Baru</a>
          <?php endif; ?>
          <div class="pt-2 flex gap-2">
            <a href="/profil" class="<?= $linkCls($isActive('/profil')) ?> flex-1 justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg" tabindex="-1" aria-current="<?= $isActive('/profil') ? 'page' : 'false' ?>">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 0115 0" />
              </svg>
              <span>Profil</span>
            </a>
            <form method="post" action="/logout" class="flex-1">
              <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">
              <button type="submit" class="btn btn-secondary w-full">Keluar</button>
            </form>
          </div>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <?php endif; ?>

  <main id="main-content" class="max-w-6xl mx-auto px-4 py-8 flex-1" role="main" tabindex="-1">
    <?php include $view_template_path; ?>
  </main>
  
  <?php if (!$isAuthPage): ?>
    <footer class="text-center text-sm text-gray-500 py-8 mt-auto border-t border-gray-200 bg-gray-50" role="contentinfo">
      <p>&copy; <?= date('Y') ?> Posyandu Lansia. Semua hak dilindungi.</p>
    </footer>
  <?php endif; ?>

  <script>
    // Mobile nav toggle with smooth animation and keyboard navigation
    (function(){
      const btn = document.getElementById('navToggle');
      const menu = document.getElementById('mobileMenu');
      const iconMenu = document.getElementById('iconMenu');
      const iconClose = document.getElementById('iconClose');
      if(!btn || !menu) return;
      
      const menuLinks = menu.querySelectorAll('a');
      let isOpen = false;
      
      function toggleMenu() {
        if (isOpen) {
          closeMenu();
        } else {
          openMenu();
        }
      }
      
      function openMenu() {
        isOpen = true;
        menu.classList.remove('hidden');
        
        // Calculate the actual height needed
        const actualHeight = menu.scrollHeight;
        
        // Start from 0 height
        menu.style.maxHeight = '0px';
        
        // Force reflow
        menu.offsetHeight;
        
        // Animate to full height
        menu.style.maxHeight = actualHeight + 'px';
        
        // Update button state and accessibility
        btn.setAttribute('aria-expanded', 'true');
        btn.setAttribute('aria-label', 'Tutup menu navigasi');
        btn.querySelector('.sr-only').textContent = 'Tutup menu navigasi';
        iconMenu.classList.add('hidden');
        iconClose.classList.remove('hidden');
        
        // Enable keyboard navigation for menu links
        menuLinks.forEach(link => {
          link.setAttribute('tabindex', '0');
        });
        
        // Focus first menu item for keyboard users
        if (menuLinks.length > 0) {
          setTimeout(() => {
            menuLinks[0].focus();
          }, 200);
        }
        
        // Trap focus within menu
        document.addEventListener('keydown', trapFocus);
        
        // Announce menu state to screen readers
        announceToScreenReader('Menu navigasi dibuka');
      }
      
      function closeMenu() {
        isOpen = false;
        
        // Get current height and animate to 0
        const currentHeight = menu.scrollHeight;
        menu.style.maxHeight = currentHeight + 'px';
        
        // Force reflow
        menu.offsetHeight;
        
        // Animate to 0 height
        menu.style.maxHeight = '0px';
        
        // Update button state and accessibility
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-label', 'Buka menu navigasi');
        btn.querySelector('.sr-only').textContent = 'Buka menu navigasi';
        iconMenu.classList.remove('hidden');
        iconClose.classList.add('hidden');
        
        // Disable keyboard navigation for menu links
        menuLinks.forEach(link => {
          link.setAttribute('tabindex', '-1');
        });
        
        // Remove focus trap
        document.removeEventListener('keydown', trapFocus);
        
        // Return focus to toggle button
        btn.focus();
        
        // Hide menu after animation completes
        setTimeout(() => {
          if (!isOpen) { // Only hide if still closed
            menu.classList.add('hidden');
          }
        }, 200);
        
        // Announce menu state to screen readers
        announceToScreenReader('Menu navigasi ditutup');
        
        // Return focus to toggle button
        btn.focus();
      }
      
      // Click event
      btn.addEventListener('click', toggleMenu);
      
      // Keyboard event for toggle button
      btn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleMenu();
        }
        if (e.key === 'Escape' && isOpen) {
          e.preventDefault();
          closeMenu();
        }
      });
      
      // Enhanced keyboard navigation within menu
      menu.addEventListener('keydown', function(e) {
        if (!isOpen) return;
        
        const focusableElements = Array.from(menuLinks);
        const currentIndex = focusableElements.indexOf(document.activeElement);
        
        switch(e.key) {
          case 'ArrowDown':
            e.preventDefault();
            const nextIndex = (currentIndex + 1) % focusableElements.length;
            focusableElements[nextIndex].focus();
            break;
            
          case 'ArrowUp':
            e.preventDefault();
            const prevIndex = currentIndex <= 0 ? focusableElements.length - 1 : currentIndex - 1;
            focusableElements[prevIndex].focus();
            break;
            
          case 'Home':
            e.preventDefault();
            focusableElements[0].focus();
            break;
            
          case 'End':
            e.preventDefault();
            focusableElements[focusableElements.length - 1].focus();
            break;
        }
      });
      
      // Focus trap function for mobile menu
      function trapFocus(e) {
        if (!isOpen) return;
        
        const focusableElements = [btn, ...menuLinks];
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        if (e.key === 'Tab') {
          if (e.shiftKey) {
            if (document.activeElement === firstElement) {
              e.preventDefault();
              lastElement.focus();
            }
          } else {
            if (document.activeElement === lastElement) {
              e.preventDefault();
              firstElement.focus();
            }
          }
        }
      }
      
      // Screen reader announcement function
      function announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        document.body.appendChild(announcement);
        
        setTimeout(() => {
          document.body.removeChild(announcement);
        }, 1000);
      }
      
      // Close menu when clicking outside
      document.addEventListener('click', function(e) {
        if (isOpen && !menu.contains(e.target) && !btn.contains(e.target)) {
          closeMenu();
        }
      });
      
      // Close menu on window resize to desktop size
      window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && isOpen) {
          closeMenu();
        }
      });
    })();

    // Add shadow on scroll for subtle depth
    (function(){
      const header = document.getElementById('siteHeader');
      if(!header) return;
      function onScroll(){
        if (window.scrollY > 8) {
          header.classList.add('shadow-sm');
          header.classList.add('border-gray-300');
        } else {
          header.classList.remove('shadow-sm');
          header.classList.remove('border-gray-300');
        }
      }
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    })();
  </script>
</body>
</html>
