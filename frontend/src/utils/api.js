import axios from "axios";

const domain = "http://127.0.0.1:8000";

const baseAPI = axios.create({
    baseURL: `${domain}/api`,
    headers: {
        "Content-Type": "application/json",
        "accept": "application/json",
    },
});

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
    try {
        const response = await baseAPI.get(url, params);
        return response.data;
    }
    catch (error) {
        console.log(error);
        return Promise.reject(error);
    }
}

async function POST(url, params) {
    try {
        const response = await baseAPI.post(url, params);
        return response.data;
    }
    catch (error) {
        console.log(error);
        return Promise.reject(error);
    }
}

async function PUT(url, params) {
    try {
        const response = await baseAPI.put(url, params);
        return response.data;
    }
    catch (error) {
        console.log(error);
        return Promise.reject(error);
    }
}
  
export { API };