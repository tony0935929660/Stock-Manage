import axios from "axios"
import store from "@/utils/store"

const baseAPI = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        "Content-Type": "application/json",
        "accept": "application/json"
    },
});

baseAPI.interceptors.request.use(
    function (config) {
        config.headers['Authorization'] = store.getters.token;
        return config;
    }
);
  

async function API(method, url, params) {
    switch (method) {
        case 'get':
            return GET(url, params);
        case 'post':
            return POST(url, params);
        case 'put':
            return PUT(url, params);
        default:
            console.log('This methods is not exist!');
    }
}

async function GET(url, params) {
    const response = await baseAPI.get(url, {'params': params});
    return response.data;
}

async function POST(url, params) {
    const response = await baseAPI.post(url, params);
    return response.data;
}

async function PUT(url, params) {
    const response = await baseAPI.put(url, params);
    return response.data;
}

export { API };