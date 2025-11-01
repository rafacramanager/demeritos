# 📘 Sistema de Gestión de Estudiantes

Este proyecto es un **sistema web en PHP** que permite gestionar la información de estudiantes, consultar deméritos y administrar registros mediante un panel (dashboard) protegido por inicio de sesión.

---

## 🚀 Características principales

- **Inicio de sesión con control de acceso**
  - Usuario tipo `superuser`: puede visualizar todos los registros de la base de datos.
  - Usuario tipo `regular`: solo puede ver los registros de su propio centro educativo.
- **Módulo de consulta de deméritos**
  - Permite consultar los deméritos de un estudiante mediante su NIE.
  - Muestra resultados en un **modal Bootstrap**.
  - Si no hay registros, muestra una alerta dentro del mismo modal.
- **Gestión de estudiantes**
  - Listado con filtros (fecha, grado, sección, turno, NIE).
  - Solo se muestran registros con estado **Activo**.
  - “Eliminación” lógica mediante el campo `estado` (Activo / Oculto).
- **Diseño responsivo con Bootstrap**
  - Formularios y tablas adaptados para dispositivos móviles.

---
🧑‍💻 Autor

Rafael Canales
Desarrollador y administrador del proyecto educativo.
📍 El Salvador
✉️ Puedes modificar este bloque con tus propios datos si lo publicas en GitHub.

🪪 Licencia

Este proyecto se distribuye bajo licencia MIT, lo que permite su uso, modificación y redistribución libremente con fines educativos o de mejora institucional.
## 🧩 Estructura del proyecto

