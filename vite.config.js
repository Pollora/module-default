import { defineConfig } from 'vite';
import pollora from '@pollora/vite-config';

// Builds into public/build/module/%module_slug%, where Pollora serves the module.<slug> asset container
export default defineConfig({
    plugins: [pollora({ type: 'module', name: '%module_slug%' })],
});
