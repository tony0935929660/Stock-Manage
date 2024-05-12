import axios from "axios";

const token = null;
const domain = "http://127.0.0.1:8000";
const baseAPI = axios.create({
    baseURL: `${domain}/api`,
    headers: {
        "Content-Type": "application/json",
        "accept": "application/json"
    },
});

function setToken(newToken) {
    const token = newToken;

    return token;
}

baseAPI.interceptors.request.use(
    function (config) {
        config.headers['Authorization'] = token;
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
    const response = await baseAPI.get(url, params);
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