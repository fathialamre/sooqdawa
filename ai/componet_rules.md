🛠️ Laravel + Filament Resource Generation Guidelines (Sooqadawa Standards)
Please follow these rules when generating tables and Filament resources. These rules are compatible with Cursor AI and Idea AI workflows:

1. ✅ Create Table, Model, and Seeder

- Follow Laravel conventions.
- Place seeder in database/seeders.

2. 🧩 Generate Filament Resource

- Place resource files under: app/Filament/Resources
- Use existing resources as references for consistency.

3. 🎨 Build an Info List with Sweet Style

- Use InfoList with well-structured layouts.
- Add icons, badges, and styling to match Sooqadawa UI patterns.

4. 🌐 Add Translations

- Add labels/messages to:
  - lang/ar/messages.php
  - lang/en/messages.php
- Use descriptive keys, and include singular/plural where applicable.

5. 📚 Always Refer to Filament 4 Documentation

- The latest Filament 4 docs are included in Cursor's doc integration.
- Ensure all components and patterns are up to date.

6. ♻️ Enable Soft Deletes

- Use SoftDeletes in models.
- Add support in Filament tables and forms (e.g. filters, restore action).

7. 🧱 Follow Laravel and Filament Best Practices

- Resource naming (singular vs plural).
- Use form components properly (e.g., validations, relationships).
- Keep controllers and services clean and modular.