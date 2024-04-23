<template>
    <b-navbar toggleable="lg" type="dark" variant="info" class="fixed-top py-0 p-1">
        <b-navbar-brand><a href="#" style="color: black; text-decoration: none;">ICT Assets Inventory</a></b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item :active="$page.url === '/items'">
                    <Link href="/items" class="nav-link">Items</Link>
                </b-nav-item>
                <b-nav-item :active="$page.url === '/inventories'">
                    <Link href="/inventories" class="nav-link">Inventories</Link>
                </b-nav-item>
                <b-nav-item :active="$page.url === '/employees'">
                    <Link href="/employees" class="nav-link">Employees</Link>
                </b-nav-item>
                <b-nav-item :active="$page.url === '/assigns'">
                    <Link href="/assigns" class="nav-link">Assigns</Link>
                </b-nav-item>
                <b-nav-item :active="$page.url === '/home'">
                    <Link href="/home" class="nav-link">Testing</Link>
                </b-nav-item>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
import { Link } from '@inertiajs/vue2'

export default {
    components: {
        Link,
    }
}
</script>
