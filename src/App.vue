<template>
    <div class="container mt-3">
        <div class="row d-print-none">
            <div>
                <h1>{{ $t('title') }}</h1>
            </div>
        </div>
        <div class="row mt-2">
            <router-view/>
        </div>
    </div>
</template>
