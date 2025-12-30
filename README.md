# Poetry Blog

A modern, multilingual poetry blog application built with Laravel and Vue.js. This application allows you to manage and display poetry collections, books, and sources with support for multiple languages.

## Features

### Public Website
- 🎲 **Random Poem Display**: Home page shows a randomly selected poem with smart excerpt functionality
- 📚 **Books Library**: Browse poetry books with covers, descriptions, and publishing information
- 📖 **Book Details**: View individual books with ordered poem listings
- ✍️ **Poem Pages**: Read full poems with navigation between poems in the same book
- 🗂️ **All Poems**: Browse all poems organized by books, sources, or unpublished
- 👤 **About Page**: Display author information and biography
- 🌐 **Multilingual**: Full support for Slovak (default) and English languages
- 🌓 **Dark/Light Mode**: Toggle between themes with preference persistence
- 📱 **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices

### Admin Panel (Filament)
- ✏️ **Content Management**: Full CRUD operations for poems, books, sources, and authors
- 🔤 **Translatable Fields**: Manage content in multiple languages through JSON storage
- 📷 **File Uploads**: Upload book covers, author images, and PDF files
- 🔢 **Poem Ordering**: Set position for poems within books
- 🎨 **Rich Interface**: Modern, intuitive admin interface with Filament PHP v4

## Tech Stack

### Backend
- **Laravel 12**: PHP framework
- **SQLite**: Lightweight database
- **Filament PHP v4**: Admin panel
- **Inertia.js**: Modern monolith approach (server-side routing with client-side rendering)

### Frontend
- **Vue 3**: Progressive JavaScript framework
- **TypeScript**: Type-safe JavaScript
- **Tailwind CSS v4**: Utility-first CSS framework
- **Vite**: Fast build tool
- **Laravel Wayfinder**: Type-safe routing for Vue

### Development Tools
- **Laravel Breeze**: Authentication scaffolding
- **Pest**: Testing framework
- **Pint**: PHP code style fixer
- **ESLint & Prettier**: Code formatting

## Requirements

- PHP 8.2+
- Node.js 18+
- Composer 2+
- SQLite3

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd poetry-blog
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite
```

### 4. Database Setup

```bash
# Run migrations and seed the database with sample data
php artisan migrate:fresh --seed

# This will create:
# - 8 sample books
# - 5 sample sources
# - 40-64 poems in books
# - 10-20 poems from sources
# - 10 unpublished poems
# - Sample author information
```

### 5. Storage Setup

```bash
# Create symbolic link for file storage
php artisan storage:link
```

### 6. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# For production
npm run build
```

### 7. Create Admin User

```bash
php artisan tinker

# In tinker console:
$user = User::first();
$user->update(['password' => Hash::make('your-secure-password')]);
exit
```

### 8. Start Development Server

```bash
# Option 1: Laravel's built-in server
php artisan serve

# Option 2: If using Laravel Valet (macOS)
valet link poetry-blog

# Option 3: Use the dev script (runs server, queue, logs, and vite concurrently)
composer dev
```

## Usage

### Accessing the Application

- **Public Website**: `http://localhost:8000` (or `http://poetry-blog.test` with Valet)
- **Admin Panel**: `http://localhost:8000/admin`
  - Email: `admin@example.com`
  - Password: (the one you set in step 7)

### Managing Content

1. **Log in to Admin Panel** at `/admin`
2. **Add Books**: Navigate to Books → Create → Add title, cover, year, publisher, description
3. **Add Poems**: Navigate to Poems → Create → Add title, body, select book (optional), set position
4. **Add Sources**: Navigate to Sources → Create → Add name, type, URL
5. **Update Author**: Navigate to Authors → Edit → Update bio and image

### Language Management

- **Frontend**: Use the language dropdown in the header to switch between Slovak and English
- **Admin Panel**: All translatable fields accept JSON format: `{"sk": "Slovak text", "en": "English text"}`

## Project Structure

```
poetry-blog/
├── app/
│   ├── Filament/Resources/     # Admin panel resources
│   ├── Http/Controllers/       # Web controllers
│   ├── Models/                 # Eloquent models
│   └── Services/               # Business logic
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── js/
│   │   ├── composables/        # Vue composables
│   │   ├── layouts/            # Layout components
│   │   ├── pages/              # Page components
│   │   └── routes/             # Generated routes (Wayfinder)
│   ├── lang/                   # Translation files
│   │   ├── sk/                 # Slovak translations
│   │   └── en/                 # English translations
│   └── views/                  # Blade templates
├── routes/
│   └── web.php                 # Web routes
└── storage/
    └── app/public/             # Public file storage
        ├── books/              # Book covers & PDFs
        └── authors/            # Author images
```

## Models & Relationships

### Poem
- Belongs to Book (optional)
- Belongs to Source (optional)
- JSON fields: `title`, `body`

### Book
- Has many Poems
- JSON fields: `title`, `publishing_house`, `description`
- Files: `cover`, `pdf_path`

### Source
- Has many Poems
- JSON fields: `name`
- Types: newspaper, magazine, website, other

### Author
- Singleton model
- JSON fields: `bio`
- Files: `image_path`

### Language
- Simple lookup table for available languages

## Development Commands

```bash
# Start dev environment with hot reload
npm run dev

# Build for production
npm run build

# Run tests
php artisan test

# Fix code style
composer pint
npm run lint

# Generate routes (after adding new routes)
php artisan wayfinder:generate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Configuration

### Default Language
Set in `.env`:
```env
APP_LOCALE=sk
APP_FALLBACK_LOCALE=sk
```

### Adding More Languages

1. Create language files in `resources/lang/{locale}/messages.php`
2. Add to Language model seeder
3. Update language dropdown in `MainLayout.vue`
4. Update middleware to recognize new locale

## Customization

### Styling
- Modify Tailwind configuration in `tailwind.config.js`
- Update theme colors and styles
- Dark mode classes follow Tailwind's `dark:` variant pattern

### Translations
- Edit files in `resources/lang/sk/messages.php` and `resources/lang/en/messages.php`
- Add new translation keys as needed

### Poem Excerpt Logic
- Located in `Home.vue` component
- Configurable character limit (default: 150)
- Smart line-break detection

## Deployment

### Production Checklist

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   ```

2. **Optimize Application**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Build Assets**
   ```bash
   npm run build
   ```

4. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

5. **Database**
   - For production, consider using MySQL/PostgreSQL instead of SQLite
   - Run migrations: `php artisan migrate --force`

## Troubleshooting

### Issue: Routes not found
**Solution**: Regenerate routes with `php artisan wayfinder:generate`

### Issue: Styles not loading
**Solution**: 
- Run `npm run build`
- Clear browser cache
- Check `public/build` directory exists

### Issue: Images not displaying
**Solution**: 
- Ensure `php artisan storage:link` has been run
- Check file permissions on `storage/app/public`

### Issue: Translations not working
**Solution**: 
- Clear config cache: `php artisan config:clear`
- Verify locale files exist in `resources/lang/`
- Check browser's stored locale preference

## License

This project is open-sourced software.

## Credits

Built with Laravel, Vue.js, Inertia.js, Filament PHP, and Tailwind CSS.
