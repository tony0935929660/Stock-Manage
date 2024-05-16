import axios from "axios"
import store from "@/utils/store"

const domain = "http://127.0.0.1:8000";
const baseAPI = axios.create({
    baseURL: `${domain}/api`,
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