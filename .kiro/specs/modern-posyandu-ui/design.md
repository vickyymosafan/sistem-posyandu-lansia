# Design Document

## Overview

Design ini akan mengubah UI/UX sistem posyandu lansia menjadi lebih modern dengan pendekatan no-rigid design, menggunakan solid colors, dan meningkatkan user experience. Fokus utama adalah pada visual consistency, modern aesthetics, dan usability tanpa mengubah struktur backend atau database.

## Architecture

### Design System Approach
- **Color Palette**: Menggunakan solid colors dengan primary blue, secondary green, dan neutral grays
- **Typography**: Menggunakan system fonts dengan hierarchy yang jelas
- **Spacing**: Menggunakan consistent spacing scale (4px, 8px, 16px, 24px, 32px)
- **Border Radius**: Menggunakan rounded corners yang konsisten (8px, 12px, 16px)
- **Shadows**: Menggunakan subtle shadows untuk depth tanpa berlebihan

### Layout Structure
- **Container**: Max-width dengan padding yang konsisten
- **Grid System**: Menggunakan CSS Grid dan Flexbox untuk responsive layout
- **Card-based Design**: Informasi diorganisir dalam cards dengan proper spacing
- **Mobile-first**: Responsive design yang prioritas mobile experience

## Components and Interfaces

### 1. Navigation Bar
**Current State**: Navbar dengan gradient background dan basic styling
**New Design**:
- Clean white background dengan subtle border bottom
- Logo dengan icon yang lebih modern
- Menu items dengan rounded hover states
- Mobile hamburger menu dengan smooth animation
- Active state dengan solid background color (bukan gradient)

### 2. Form Components
**Current State**: Basic form styling dengan minimal visual feedback
**New Design**:
- Input fields dengan rounded corners dan focus states
- Labels dengan proper typography hierarchy
- Validation messages dengan appropriate colors
- Submit buttons dengan solid colors dan loading states
- Form containers dengan subtle shadows

### 3. Card Components
**Current State**: Basic white containers dengan minimal styling
**New Design**:
- Cards dengan subtle shadows dan rounded corners
- Proper padding dan spacing
- Hover effects untuk interactive cards
- Information hierarchy dengan typography scales
- Action buttons dengan consistent styling

### 4. Table Components
**Current State**: Basic table dengan minimal styling
**New Design**:
- Modern table dengan alternating row colors
- Rounded table container
- Proper spacing dan typography
- Action buttons dengan consistent styling
- Responsive table behavior

### 5. Button Components
**Current State**: Basic buttons dengan gradient backgrounds
**New Design**:
- Solid color buttons dengan proper hover states
- Consistent sizing dan padding
- Loading states dengan spinners
- Different variants (primary, secondary, success, danger)
- Proper focus states untuk accessibility

## Data Models

Tidak ada perubahan pada data models karena fokus hanya pada UI/UX improvements.

## Error Handling

### Visual Error States
- Form validation errors dengan red color dan clear messaging
- Loading states untuk async operations
- Empty states dengan helpful messaging
- Error pages dengan consistent styling

### User Feedback
- Success messages dengan green color
- Warning messages dengan yellow/orange color
- Info messages dengan blue color
- Toast notifications untuk quick feedback

## Testing Strategy

### Visual Testing
- Cross-browser compatibility testing
- Responsive design testing pada berbagai device sizes
- Color contrast testing untuk accessibility
- Typography readability testing

### User Experience Testing
- Navigation flow testing
- Form interaction testing
- Mobile usability testing
- Performance testing untuk smooth animations

## Implementation Details

### Color Palette
```css
Primary Colors:
- Blue: #3B82F6 (primary actions)
- Green: #10B981 (success, health-related)
- Red: #EF4444 (errors, warnings)

Neutral Colors:
- Gray-50: #F9FAFB (backgrounds)
- Gray-100: #F3F4F6 (subtle backgrounds)
- Gray-200: #E5E7EB (borders)
- Gray-600: #4B5563 (secondary text)
- Gray-900: #111827 (primary text)
```

### Typography Scale
```css
Headings:
- H1: 2rem (32px) - font-weight: 700
- H2: 1.5rem (24px) - font-weight: 600
- H3: 1.25rem (20px) - font-weight: 600

Body Text:
- Large: 1rem (16px) - font-weight: 400
- Regular: 0.875rem (14px) - font-weight: 400
- Small: 0.75rem (12px) - font-weight: 400
```

### Spacing Scale
```css
Spacing:
- xs: 0.25rem (4px)
- sm: 0.5rem (8px)
- md: 1rem (16px)
- lg: 1.5rem (24px)
- xl: 2rem (32px)
```

### Border Radius
```css
Radius:
- sm: 0.5rem (8px) - buttons, inputs
- md: 0.75rem (12px) - cards
- lg: 1rem (16px) - containers
```

## File Structure

Files yang akan dimodifikasi:
1. `app/Views/layouts/main.php` - Main layout dan navbar
2. `app/Views/home/index.php` - Homepage cards
3. `app/Views/lansia/index.php` - Data table dan search
4. `app/Views/lansia/create.php` - Registration form
5. `app/Views/lansia/show.php` - Profile display
6. `app/Views/find/index.php` - Search form
7. `app/Views/pemeriksaan/form.php` - Examination forms

## Responsive Breakpoints

```css
Mobile: < 768px
Tablet: 768px - 1024px
Desktop: > 1024px
```

## Animation Guidelines

- Hover transitions: 150ms ease-in-out
- Focus transitions: 100ms ease-in-out
- Loading animations: smooth spinners
- Mobile menu animations: 200ms ease-in-out