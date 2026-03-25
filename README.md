<p align="center">
<img src="logo.png" width="300" alt="GrafiPrinter Logo">
</p>

## 📝 Descripción
**El SISTEMA PARA LA GESTIÓN DE LOS PROCESOS ADMINISTRATIVOS Y PRODUCTIVOS DE LA EMPRESA GRAFIPRINTER 360, C.A**. Ha sido diseñado para unificar la administración y la manufactura dentro de la organización. Este proyecto transforma los procesos manuales en un flujo digital automatizado que abarca desde la captación administrativa y gestión de cobranzas, hasta el control técnico de los lotes de impresión y serigrafía. El sistema asegura un entorno robusto para la toma de decisiones, eliminando cuellos de botella en la cadena de producción y garantizando un manejo seguro y eficiente de los datos.

---

## 🛠️ Tecnologías Utilizadas
Este apartado es fundamental para la revisión técnica del tutor:

* **Framework:** 🚀 [Laravel 13](https://laravel.com)
* **Lenguaje:** 🐘 PHP 8.x
* **Base de Datos:** 🗄️ MySQL (desarrollo) / PostgreSQL (producción)
* **Frontend:** 🎨 Tailwind CSS & Blade Templates
* **Gestores:** 📦 Composer & Node.js (Vite)
* **Control de Versiones:** 📂 Git & GitHub

---

## 🔑 Características Principales
* **Seguridad Avanzada:** Protección con Google reCAPTCHA v2 y bloqueo de intrusos.
* **Roles de Usuario:** Acceso diferenciado para Administradores y Encargados.
* **Auditoría:** Registro de bitácora para todas las transacciones del sistema.
* **Interfaz Adaptable:** Diseño moderno compatible con dispositivos móviles.
* **Módulos:** Gestión de Pedidos, Inventario, Productos y Usuarios.

---

## ⚙️ Configuración Rápida
Si deseas desplegar el proyecto localmente, sigue estos pasos:

### Requisitos
- PHP 8.x
- Composer
- Node.js y npm
- MySQL (o PostgreSQL)

### Pasos
1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/sistema-grafiprinter.git
   cd sistema-grafiprinter
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Configurar el entorno:**
   - Copia `.env.example` a `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edita `.env` con tus datos de DB (ej: DB_CONNECTION=mysql, DB_DATABASE=grafiprinter).
   - Genera la llave:
     ```bash
     php artisan key:generate
     ```

4. **Base de Datos:**
   ```bash
   php artisan migrate
   php artisan db:seed  # Si hay seeders
   ```

5. **Ejecutar la aplicación:**
   ```bash
   php artisan serve
   ```
   Visita `http://localhost:8000`.

---

## 👥 Desarrollo
Desarrollador: [Spiral]

Institución: UPTAG - PNF Informática

Año: 2026
