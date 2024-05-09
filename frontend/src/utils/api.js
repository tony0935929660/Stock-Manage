import axios from "axios";

const domain = "http://127.0.0.1:8000";
const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTUyNDUwOTYsImV4cCI6MTcxNTI0ODY5NiwibmJmIjoxNzE1MjQ1MDk2LCJqdGkiOiJvUGVvdEJkVlZzMlc0MUdCIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.qrgGGwvDk-0Hb7zv5Xw8MUANbB9i8Jo0Y35o-Cckt9Q";

const baseAPI = axios.create({
    baseURL: `${domain}/api`,
    headers: {
        "Content-Type": "application/json",
        "accept": "application/json",
        "Authorization": `Bearer ${token}`
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