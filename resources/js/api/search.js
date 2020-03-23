import request from '@/utils/request';

export function userSearch(name) {
  return request({
    url: '/search/user',
    method: 'get',
    params: { name },
  });
}

export function searchVolunteers(name, type) {
  return request({
    url: '/search/volunteers',
    method: 'get',
    params: { name, type },
  });
}

export function getMapVolunteers(name) {
  return request({
    url: '/volunteers-map',
    method: 'get',
    params: { name },
  });
}
