<template>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="#">NavBar</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item>
                    <Link href="/items">Item</Link>
                </b-nav-item>
                <b-nav-item>
                    <Link href="/inventories">Inventory</Link> 
                </b-nav-item>
                <b-nav-item>
                    <Link href="/employees">Employee</Link> 
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
