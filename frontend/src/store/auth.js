export function getUser() {
    return JSON.parse(sessionStorage.getItem('user'));
  }
  
  export function isLoggedIn() {
    return !!getUser();
  }
  