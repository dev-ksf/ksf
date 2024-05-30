import { ofetch } from 'ofetch';

export const $api = ofetch.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '/api',
  async onRequest({ options }) {
    const accessToken = useCookie('accessToken').value
    if (accessToken) {
      options.headers = {
        ...options.headers,
        Authorization: `Bearer ${accessToken}`,
      }
    }
  },
  async onResponse({ request, response, options }) {
    if (
            response.status === 401 && 
            response.url !== import.meta.env.VITE_API_BASE_URL + "/v1/login"
        ) {
          /* automatically logged out if not login upon request */
          window.location.href =
              import.meta.env.VITE_APP_BASEURL + "/login";
        }

  },
})
