# EDIT PLAN: Fix ParseError in products/show.blade.php

## Information Gathered

- **Error**: ParseError line 561 expecting '@elseif', '@else', or '@endif'
- **Trigger**: From section/category page → product/12
- **Controller**: `VisitorProductController@show` - clean, passes `product`, `category`, `variants`, `relatedProducts`, `generalDiscounts`
- **Layout**: `layouts/pro-store.blade.php` - clean
- **Blade Search**: No unclosed @if across project
- **File Content**: Appears syntactically correct but error suggests hidden BOM/encoding or unclosed block at EOF

## Plan

**Step 1**: Overwrite `resources/views/products/show.blade.php` with verified clean version (COMPLETE content below)
**Step 2**: Clear view cache
**Step 3**: Test /product/12

**Primary File**: resources/views/products/show.blade.php (overwrite - contains exact error)

**Dependent Files**: None (controller/layout clean)

## Followup Steps

1. `php artisan view:clear && php artisan config:clear`
2. Test `http://127.0.0.1:8000/product/12`
3. Update TODO.md
4. Commit changes

**Do you approve this plan? Reply 'yes' to proceed with file replacement.**
