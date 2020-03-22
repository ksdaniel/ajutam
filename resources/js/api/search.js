import request from '@/utils/request';

export function userSearch(name) {
  return request({
    url: '/search/user',
    method: 'get',
    params: { name },
  });
}

export function searchVolunteers(name) {
  return request({
    url: '/search/volunteers',
    method: 'get',
    params: { name },
  });
}
