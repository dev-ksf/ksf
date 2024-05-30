import type { App } from 'vue';

import Toast, { PluginOptions } from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

// Styles
import '@layouts/styles/index.scss';

export default function (app: App) {

  const options: PluginOptions = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 10,
    newestOnTop: true
  };

  app.use(Toast, options);
}
