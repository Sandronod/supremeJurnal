<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $items = MenuItem::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu-items.index', ['items' => $items]);
    }

    public function create(): View
    {
        return view('admin.menu-items.create', [
            'targets' => MenuItem::internalTargets(),
            'parents' => $this->topLevelItems(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateItem($request);

        MenuItem::create($data);

        return redirect()->route('admin.menu-items.index')->with('status', 'menu-item-created');
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('admin.menu-items.edit', [
            'item' => $menuItem,
            'targets' => MenuItem::internalTargets(),
            'parents' => $this->topLevelItems($menuItem),
            'selectedTarget' => $this->targetKeyFor($menuItem),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $data = $this->validateItem($request, $menuItem);

        $menuItem->update($data);

        return redirect()->route('admin.menu-items.index')->with('status', 'menu-item-updated');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')->with('status', 'menu-item-deleted');
    }

    /**
     * Only top-level items can be chosen as a parent (keeps nesting to one
     * level, matching the original two-tier dropdown menu design) — an item
     * can have any number of children, so items with existing children stay
     * eligible. When editing, the item can't be its own parent (a separate
     * check in validateItem() also stops an item with children from being
     * assigned a parent, since that would create a third level).
     */
    private function topLevelItems(?MenuItem $editing = null)
    {
        return MenuItem::whereNull('parent_id')
            ->when($editing, fn ($q) => $q->where('id', '!=', $editing->id))
            ->orderBy('sort_order')
            ->get();
    }

    private function targetKeyFor(MenuItem $item): ?string
    {
        if (! $item->route_name) {
            return null;
        }

        foreach (MenuItem::internalTargets() as $key => $target) {
            if ($target['route'] === $item->route_name && $target['param'] === $item->route_param) {
                return $key;
            }
        }

        return null;
    }

    private function validateItem(Request $request, ?MenuItem $editing = null): array
    {
        $validated = $request->validate([
            'label_ka' => ['required', 'string', 'max:255'],
            'label_en' => ['required', 'string', 'max:255'],
            'link_type' => ['required', 'in:internal,custom'],
            'internal_target' => ['required_if:link_type,internal', 'nullable', 'string'],
            'custom_url' => ['required_if:link_type,custom', 'nullable', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:menu_items,id'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($validated['parent_id'] ?? null) {
            $parent = MenuItem::findOrFail($validated['parent_id']);
            abort_if($parent->parent_id !== null, 422, 'Only a top-level item can be a parent.');
            abort_if($editing && $editing->id === $parent->id, 422, 'An item cannot be its own parent.');
            abort_if($editing && $editing->children()->exists(), 422, 'An item with submenu items cannot itself become a submenu item.');
        }

        $data = [
            'label_ka' => $validated['label_ka'],
            'label_en' => $validated['label_en'],
            'parent_id' => $validated['parent_id'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'route_name' => null,
            'route_param' => null,
            'custom_url' => null,
        ];

        if ($validated['link_type'] === 'internal') {
            $targets = MenuItem::internalTargets();
            abort_unless(isset($targets[$validated['internal_target']]), 422, 'Unknown internal target.');
            $data['route_name'] = $targets[$validated['internal_target']]['route'];
            $data['route_param'] = $targets[$validated['internal_target']]['param'];
        } else {
            $data['custom_url'] = $validated['custom_url'];
        }

        return $data;
    }
}
