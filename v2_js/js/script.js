/*Login details to change*/
const user = "testazerty"
const pass = "testazerty"

//Bypass Cross Origin Policy
const corsProxy = "https://cors-anywhere.herokuapp.com/"

const apiBaseUrl = "https://api.appvertical.com/api/"

const log = (...ele) => ele.forEach(x => console.log(x))

const reqAPI = (apiUrl, httpMethod, dataParam, headersParam) => {
	return new Promise((resolve, reject) => {
		let request = $.ajax({
			url: corsProxy + apiBaseUrl + apiUrl,
			method: httpMethod || "GET",
			data: dataParam || {},
			headers: headersParam || {}
		})
		request.done(msg => resolve(msg))
		request.fail((jqXHR, textStatus) => reject(jqXHR.responseJSON))
	})
}

const login = (vusername, vpassword, returnOnlyTheToken) => {
	if (!vusername || !vpassword)
		return
	const dataParam = {
		login: vusername,
		password: vpassword
	}
	return reqAPI("login/authenticate", "POST", dataParam)
}

const getHome = authToken => {
	if (!token)
		return
	const headersParam = {
		"X-Access-Token": authToken
	}
	return reqAPI("playlists?page=1&limit=9999999", "GET", null, headersParam)
}

const startScript = async (vusername, vpassword) => {
	login(vusername, vpassword, true)
		.catch(e => {
			log(e)
			return null
		})
		.then(res => {
			if (!res)
				return
			let authToken = res.token
			getHome(authToken)
				.catch(e => {
					log(e)
					return null
				})
				.then(res => log(res))
		})
}