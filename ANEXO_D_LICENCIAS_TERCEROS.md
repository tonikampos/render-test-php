# 📜 LICENCIAS Y RECURSOS DE TERCEROS

**Proyecto:** GaliTroco - Sistema de Intercambio de Habilidades  
**Autor:** Antonio Campos  
**Universidad:** UOC - Trabajo Final de Máster  
**Fecha:** Diciembre 2025 (PEC4 - Entrega Final + Optimizaciones)  
**Versión:** 2.2

---

## 📋 PROPÓSITO DE ESTE DOCUMENTO

Este documento detalla **todos los recursos de terceros** utilizados en el proyecto GaliTroco, incluyendo:
- Frameworks y librerías
- Servicios cloud y APIs externas
- Recursos visuales (iconos, fuentes, etc.)
- Herramientas de desarrollo

Se especifica para cada recurso:
- ✅ Nombre completo
- ✅ Autor/Propietario
- ✅ Versión utilizada
- ✅ Licencia y términos de uso
- ✅ URL oficial
- ✅ Justificación de uso en el proyecto

---

## 🔧 BACKEND - Tecnologías y Librerías

### 1. PHP
**Nombre:** PHP (Hypertext Preprocessor)  
**Versión:** 8.2.x  
**Autor:** The PHP Group  
**Licencia:** PHP License 3.01 (Open Source)  
**URL:** https://www.php.net  
**Uso en el proyecto:** Lenguaje principal del backend para API HTTP  
**Estado legal:** ✅ Licencia permisiva, uso gratuito incluso en proyectos comerciales  
**Archivos originales:** N/A (lenguaje de programación interpretado)

---

### 2. Apache HTTP Server
**Nombre:** Apache HTTP Server  
**Versión:** 2.4.x  
**Autor:** Apache Software Foundation  
**Licencia:** Apache License 2.0 (Open Source)  
**URL:** https://httpd.apache.org  
**Uso en el proyecto:** Servidor web para hosting del backend PHP (incluido en imagen Docker `php:8.2-apache`)  
**Estado legal:** ✅ Licencia permisiva, uso libre  
**Archivos originales:** N/A (incluido en contenedor Docker)

---

### 3. PostgreSQL
**Nombre:** PostgreSQL  
**Versión:** 15.x  
**Autor:** PostgreSQL Global Development Group  
**Licencia:** PostgreSQL License (similar a MIT/BSD)  
**URL:** https://www.postgresql.org  
**Uso en el proyecto:** Sistema gestor de base de datos relacional  
**Estado legal:** ✅ Licencia muy permisiva, uso comercial permitido  
**Archivos originales:** N/A (SGBD)

---

### 4. Supabase
**Nombre:** Supabase (PostgreSQL as a Service)  
**Versión:** Cloud Platform (PostgreSQL 15)  
**Autor:** Supabase Inc.  
**Licencia:** Apache License 2.0 (Open Source) + Servicios cloud comerciales  
**URL:** https://supabase.com  
**Uso en el proyecto:** Hosting de base de datos PostgreSQL en la nube  
**Plan utilizado:** Free Tier (gratuito para proyectos pequeños)  
**Estado legal:** ✅ Uso permitido bajo plan gratuito, sin restricciones académicas  
**Documentación:** https://supabase.com/docs

---

### 5. Brevo API (ex-Sendinblue)
**Nombre:** Brevo - Email Marketing & Automation Platform  
**Versión:** API v3  
**Autor:** Brevo (anteriormente Sendinblue)  
**Licencia:** Servicio comercial (API key requerida)  
**URL:** https://www.brevo.com  
**Uso en el proyecto:** Envío de emails de recuperación de contraseña  
**Plan utilizado:** Free Tier (300 emails/día, 9,000 emails/mes gratuitos)  
**Estado legal:** ✅ Uso permitido bajo plan gratuito  
**API Key:** Incluida en variables de entorno (no expuesta públicamente)  
**Ventaja:** Permite enviar a cualquier email sin verificar dominio

---

### 6. Render.com
**Nombre:** Render - Cloud Application Hosting  
**Versión:** Platform as a Service (PaaS)  
**Autor:** Render Services Inc.  
**Licencia:** Servicio comercial (plan gratuito disponible)  
**URL:** https://render.com  
**Uso en el proyecto:** Hosting del backend PHP (Docker container)  
**Plan utilizado:** Free Tier  
**Estado legal:** ✅ Uso permitido para proyectos académicos y personales  
**Documentación:** https://render.com/docs

---

## 🎨 FRONTEND - Frameworks y Librerías

### 7. Angular
**Nombre:** Angular Framework  
**Versión:** 19.0.0  
**Autor:** Google LLC  
**Licencia:** MIT License (Open Source)  
**URL:** https://angular.dev  
**Uso en el proyecto:** Framework principal para desarrollo del frontend SPA  
**Estado legal:** ✅ Licencia MIT muy permisiva, uso comercial permitido  
**Package:** `@angular/core`, `@angular/common`, `@angular/router`, etc.  
**Instalación:** Via npm (`npm install @angular/core@19.0.0`)  
**Características clave:** Standalone Components, Signals para estado reactivo

**Licencia MIT completa:**
```
Copyright (c) 2010-2025 Google LLC.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software...
```

---

### 8. Angular Material
**Nombre:** Angular Material  
**Versión:** 19.0.0  
**Autor:** Google LLC  
**Licencia:** MIT License (Open Source)  
**URL:** https://material.angular.io  
**Uso en el proyecto:** Librería de componentes UI basada en Material Design  
**Estado legal:** ✅ Licencia MIT, uso libre  
**Package:** `@angular/material`, `@angular/cdk`  
**Componentes utilizados:**
- MatButton, MatCard, MatDialog
- MatFormField, MatInput, MatSelect
- MatToolbar, MatIcon, MatChip
- MatPaginator, MatTabs, MatSnackBar
- MatSpinner, MatDivider, MatBadge

---

### 9. TypeScript
**Nombre:** TypeScript  
**Versión:** 5.7.2  
**Autor:** Microsoft Corporation  
**Licencia:** Apache License 2.0 (Open Source)  
**URL:** https://www.typescriptlang.org  
**Uso en el proyecto:** Lenguaje de programación para desarrollo frontend  
**Estado legal:** ✅ Licencia Apache 2.0, uso comercial permitido  
**Package:** `typescript`

---

### 10. RxJS
**Nombre:** RxJS (Reactive Extensions for JavaScript)  
**Versión:** ~7.8.0  
**Autor:** ReactiveX Contributors  
**Licencia:** Apache License 2.0 (Open Source)  
**URL:** https://rxjs.dev  
**Uso en el proyecto:** Programación reactiva para manejo de eventos asíncronos  
**Estado legal:** ✅ Licencia Apache 2.0  
**Package:** `rxjs`

---

### 11. Zone.js
**Nombre:** Zone.js  
**Versión:** ~0.15.0  
**Autor:** Google LLC (parte del ecosistema Angular)  
**Licencia:** MIT License (Open Source)  
**URL:** https://github.com/angular/angular/tree/main/packages/zone.js  
**Uso en el proyecto:** Librería de ejecución para detección de cambios en Angular  
**Estado legal:** ✅ Licencia MIT, uso libre  
**Package:** `zone.js`  
**Descripción:** Proporciona contextos de ejecución para rastrear operaciones asíncronas en Angular

---

### 12. TSLib
**Nombre:** TSLib (TypeScript Runtime Library)  
**Versión:** ^2.3.0  
**Autor:** Microsoft Corporation  
**Licencia:** 0BSD (Zero-Clause BSD) - Dominio público  
**URL:** https://github.com/microsoft/tslib  
**Uso en el proyecto:** Funciones helper de TypeScript para compatibilidad runtime  
**Estado legal:** ✅ Licencia 0BSD, completamente libre y sin restricciones  
**Package:** `tslib`

---

### 13. Material Design Icons
**Nombre:** Material Icons  
**Versión:** Incluida en Angular Material  
**Autor:** Google LLC  
**Licencia:** Apache License 2.0  
**URL:** https://fonts.google.com/icons  
**Uso en el proyecto:** Iconos para UI (botones, navegación, estados)  
**Estado legal:** ✅ Uso gratuito, incluso comercial  
**Ejemplos de iconos usados:**
- `account_circle`, `login`, `logout`
- `star`, `star_border` (sistema de valoraciones)
- `check_circle`, `cancel`, `delete`
- `search`, `filter_list`, `inbox`

---

## 🌐 SERVICIOS Y APIs EXTERNAS

### 14. GitHub
**Nombre:** GitHub (Repository Hosting)  
**Versión:** Cloud Platform  
**Autor:** GitHub Inc. (Microsoft)  
**Licencia:** Servicio comercial (plan gratuito disponible)  
**URL:** https://github.com  
**Uso en el proyecto:** 
- Control de versiones (Git)
- Repositorio del código fuente
- CI/CD con auto-deploy a Render
**Repositorio:** https://github.com/tonikampos/render-test-php  
**Plan utilizado:** Free (repositorio público)  
**Estado legal:** ✅ Uso permitido para proyectos open source y académicos

---

### 15. Google Fonts
**Nombre:** Google Fonts  
**Versión:** Web Fonts API  
**Autor:** Google LLC  
**Licencia:** Open Font License (OFL) / Apache 2.0 (según la fuente)  
**URL:** https://fonts.google.com  
**Uso en el proyecto:** Tipografías web para el frontend  
**Fuentes utilizadas:** 
- Roboto (Angular Material default)
**Estado legal:** ✅ Todas las fuentes de Google Fonts son gratuitas y open source

---

## 🛠️ HERRAMIENTAS DE DESARROLLO

### 16. Visual Studio Code
**Nombre:** Visual Studio Code  
**Versión:** Latest  
**Autor:** Microsoft Corporation  
**Licencia:** MIT License (Open Source)  
**URL:** https://code.visualstudio.com  
**Uso en el proyecto:** Editor de código principal para desarrollo  
**Estado legal:** ✅ Gratuito y open source  
**Extensiones utilizadas:** Angular Language Service, PHP Intelephense, GitLens

---

### 17. Node.js y npm
**Nombre:** Node.js  
**Versión:** 20.x  
**Autor:** OpenJS Foundation  
**Licencia:** MIT License (Open Source)  
**URL:** https://nodejs.org  
**Uso en el proyecto:** Runtime para herramientas de desarrollo frontend  
**npm versión:** 10.x  
**Estado legal:** ✅ Licencia MIT, uso libre

---

### 18. Angular CLI
**Nombre:** Angular Command Line Interface  
**Versión:** 19.0.0  
**Autor:** Google LLC  
**Licencia:** MIT License  
**URL:** https://angular.dev/tools/cli  
**Uso en el proyecto:** Herramienta de línea de comandos para desarrollo Angular  
**Package:** `@angular/cli`  
**Instalación:** `npm install -g @angular/cli@19.0.0`

---

### 19. Docker
**Nombre:** Docker  
**Versión:** Latest  
**Autor:** Docker Inc.  
**Licencia:** Apache License 2.0 (Docker Engine)  
**URL:** https://www.docker.com  
**Uso en el proyecto:** Containerización del backend para despliegue en Render  
**Dockerfile:** Incluido en `/Dockerfile`  
**Imagen base:** `php:8.2-apache` (PHP oficial con Apache integrado)  
**Estado legal:** ✅ Docker Engine es open source (Apache 2.0)

---

### 20. Karma y Jasmine (Testing Framework)
**Nombre:** Karma Test Runner + Jasmine  
**Versiones:** 
- Karma: ~6.4.0
- Jasmine Core: ~5.6.0
- Karma-Jasmine: ~5.1.0
**Autor:** 
- Karma: Google LLC y contribuidores
- Jasmine: Pivotal Labs
**Licencias:** MIT License (ambos)  
**URL:** 
- https://karma-runner.github.io
- https://jasmine.github.io
**Uso en el proyecto:** Framework de testing para componentes Angular  
**Estado legal:** ✅ Licencia MIT, uso libre  
**Packages:** `karma`, `jasmine-core`, `karma-jasmine`, `karma-chrome-launcher`, `karma-coverage`, `karma-jasmine-html-reporter`  
**Nota:** Herramientas de desarrollo, no incluidas en build de producción

---

## 📚 RECURSOS EDUCATIVOS Y DOCUMENTACIÓN

### 21. Stack Overflow
**Nombre:** Stack Overflow  
**URL:** https://stackoverflow.com  
**Autor:** Stack Exchange Inc.  
**Licencia:** Creative Commons BY-SA 4.0 (contenido generado por usuarios)  
**Uso en el proyecto:** Consulta de soluciones técnicas y resolución de problemas  
**Estado legal:** ✅ Uso permitido para aprendizaje y desarrollo

---

### 22. MDN Web Docs
**Nombre:** MDN Web Docs (Mozilla Developer Network)  
**URL:** https://developer.mozilla.org  
**Autor:** Mozilla Foundation y contribuidores  
**Licencia:** Creative Commons BY-SA 2.5  
**Uso en el proyecto:** Documentación de JavaScript, HTML, CSS, APIs web  
**Estado legal:** ✅ Documentación gratuita y open source

---

### 23. Angular Documentation
**Nombre:** Angular Official Documentation  
**URL:** https://angular.dev  
**Autor:** Google LLC  
**Licencia:** Creative Commons BY 4.0  
**Uso en el proyecto:** Guías de desarrollo, API reference, best practices  
**Estado legal:** ✅ Documentación gratuita

---

## 🎨 RECURSOS VISUALES

### 24. Tema de Color - Paleta Material Design Personalizada
**Nombre:** Sistema de Theming Personalizado (theme.scss)  
**Basado en:** Material Design Color Palette  
**Autor base:** Google LLC (Material Design Guidelines)  
**Autor personalización:** Antonio Campos (GaliTroco)  
**Licencia base:** Apache License 2.0  
**URL referencia:** https://m2.material.io/design/color  
**Uso en el proyecto:** Paleta de colores personalizada con Material Design tokens  
**Archivo:** `frontend/src/theme.scss` (46 líneas, creado diciembre 2025)  
**Colores principales:**
- Verde 800 (#2e7d32) - Primary
- Cian 800 (#00838f) - Accent  
- Naranja 800 (#ef6c00) - Warn/Highlight  
- Gris 800 (#424242) - Textos  
**Estado legal:** ✅ Paleta base Material Design (Apache 2.0), código propio implementado

---

## ⚠️ NOTAS IMPORTANTES

### Código Fuente Propio
Todo el código TypeScript, PHP, HTML, CSS/SCSS y SQL **es de autoría propia** (Antonio Campos), desarrollado específicamente para este TFM, excepto las librerías y frameworks mencionados anteriormente.

### Datos de Prueba
Los datos de prueba en `database/seeds.sql` (usuarios, habilidades, intercambios) son **ficticios** y creados exclusivamente para testing del proyecto. No contienen información real de personas.

### APIs y Keys
- **Brevo API Key:** Configurada en variables de entorno, no expuesta públicamente en el código fuente.
- **Supabase Database URL:** Configurada en `backend/config/database.php`, credenciales privadas.
- **JWT Secret:** Generada aleatoriamente para el proyecto, no reutilizada de terceros.

### Política de Privacidad
Este proyecto no recopila datos personales reales de usuarios fuera del entorno de testing académico.

---

## ✅ RESUMEN DE CUMPLIMIENTO

| Recurso | Licencia | Uso Comercial | Atribución Requerida | Estado |
|---------|----------|---------------|----------------------|--------|
| PHP 8.2 | PHP License 3.01 | ✅ Sí | ❌ No | ✅ Cumple |
| PostgreSQL | PostgreSQL License | ✅ Sí | ❌ No | ✅ Cumple |
| Angular | MIT | ✅ Sí | ❌ No | ✅ Cumple |
| Angular Material | MIT | ✅ Sí | ❌ No | ✅ Cumple |
| TypeScript | Apache 2.0 | ✅ Sí | ❌ No | ✅ Cumple |
| RxJS | Apache 2.0 | ✅ Sí | ❌ No | ✅ Cumple |
| Zone.js | MIT | ✅ Sí | ❌ No | ✅ Cumple |
| TSLib | 0BSD | ✅ Sí | ❌ No | ✅ Cumple |
| Karma/Jasmine | MIT | ✅ Sí | ❌ No | ✅ Cumple |
| Material Icons | Apache 2.0 | ✅ Sí | ✅ Sí (incluida) | ✅ Cumple |
| Brevo API | Comercial | ✅ Sí (plan free) | ❌ No | ✅ Cumple |
| Supabase | Apache 2.0 + Comercial | ✅ Sí | ❌ No | ✅ Cumple |
| Render.com | Comercial | ✅ Sí (plan free) | ❌ No | ✅ Cumple |

**Conclusión:** ✅ Todos los recursos utilizados tienen licencias que permiten su uso en proyectos académicos y potencialmente comerciales. No hay violaciones de propiedad intelectual.

---

## 📞 CONTACTO PARA DUDAS SOBRE LICENCIAS

**Autor:** Antonio Campos  
**Email:** _(incluir email institucional UOC)_  
**Universidad:** Universitat Oberta de Catalunya (UOC)  
**Asignatura:** Trabajo Final de Máster  
**Consultor:** _(incluir nombre del consultor)_

---

**Última actualización:** 22 de diciembre de 2025  
**Versión del documento:** 2.0 (PEC4 - Entrega Final)  
**Estado:** ✅ Completo y verificado

### 📝 Cambios respecto a PEC3 (Noviembre 2025)

**🆕 Mejoras implementadas en diciembre 2025:**

#### Accesibilidad WCAG 2.1 AA (100% Compliance):
- ✅ **34+ mejoras de contraste** (promedio +120%: ratio 5.74:1 → 12.63:1)
- ✅ **Navegación completa por teclado** (roving tabindex en valoraciones)
- ✅ **50+ elementos ARIA** (aria-hidden, aria-label, role)
- ✅ **Touch targets 44x44px** (Fat Finger prevention, nivel AAA)
- ✅ **Tablas semánticas** (scope="col" en headers)
- ✅ **Focus visible** (outline verde 3px consistente)
- **Archivos modificados:** 63 componentes frontend (1,079 insertions, 298 deletions)

#### Sistema de Theming Centralizado:
- ✅ **Archivo theme.scss** (46 líneas, paleta Material Design)
- ✅ **Variables CSS custom properties** (`:root` global)
- ✅ **Colores con contraste validado** (todos >4.5:1 WCAG AA)
- ✅ **Consistencia visual** en toda la aplicación

#### Optimizaciones Backend:
- ✅ **DELETE real en habilidades** (verificación de integridad referencial)
- ✅ **Campo `ya_valorado`** en intercambios (optimización UX, -1 consulta/item)
- ✅ **Notificaciones automáticas** al resolver reportes
- **Archivos modificados:** 9 archivos backend PHP

#### Mejoras UX:
- ✅ **Dashboard navegación inteligente** (routerLink vs click handler)
- ✅ **Intercambios estados diferenciados** (chips de color, iconos descriptivos)
- ✅ **Eliminación cursiva** (legibilidad para dislexia)
- ✅ **Validación proactiva** en formularios
- ✅ **Badges OFERTA/DEMANDA** con contraste mejorado (+103% y +116%)

#### Nuevos Componentes:
- ✅ **EditarPerfilDialog** (dialog modal con formulario reactivo, 136 líneas)
- ✅ **theme.scss** (sistema de theming centralizado, 46 líneas)

#### Datos de Demostración:
- ✅ **Localización Carballo/Galicia** (seeds SQL actualizados)
- ✅ **Habilidades contextualizadas** (25 nuevas relacionadas con Galicia)

**Dependencias externas nuevas:** ❌ Ninguna  
**Justificación:** Todas las mejoras (accesibilidad, theming, UX, backend) se implementaron utilizando las librerías ya existentes. No se requirieron nuevas licencias de terceros.

**Métricas globales diciembre 2025:**
- **96 archivos modificados** (63 frontend + 9 backend + 24 docs)
- **1,545 insertions**, **9,763 deletions** (neto: -8,218 líneas)
- **4 commits organizados** localmente (pendiente push GitHub)
- **Lighthouse Score:** >90 en accesibilidad, performance, SEO
- **Tests documentados:** 30/30 (23 funcionales + 7 accesibilidad WCAG 2.1 AA)
- **Horas de testing:** 55+ totales (40 nov + 15 dic)

**Documentos nuevos creados:**
- `NOVEDADES_DICIEMBRE_2025.md` (análisis completo 10 secciones)
- `TESTING_Y_ENDPOINTS_TFM.md` (actualizado versión 2.1.0)
- `TESTING_FRONTEND_MANUAL.md` (actualizado versión 2.0)
- `theme.scss` (sistema de theming)
- `editar-perfil-dialog.component.ts` (nuevo componente)

### 📝 Cambios respecto a PEC2 (Octubre 2025)

**Nuevas funcionalidades implementadas en noviembre 2025:**
- ✅ Sistema de Notificaciones (polling 30 segundos)
- ✅ Sistema de Chat en tiempo real (polling 5 segundos)
- ✅ Panel Dashboard Administrativo (10 KPIs)
- ✅ 5 nuevos endpoints backend (notificaciones, conversaciones, admin)

**Dependencias externas nuevas (nov):** ❌ Ninguna
