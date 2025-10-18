// Use DBML to define your database structure
// Docs: https://dbml.dbdiagram.io/docs

Table users {
  id string [primary key, note: 'uuid']
  first_name varchar
  last_name varchar
  email varchar [unique]
  phone varchar
  password varchar
  role enum [note: 'user - admin - guest']
  totals json [default: "{}"]
  created_at timestamp
}

Table cities {
  id string [primary key, note: 'uuid']
  title varchar
  created_at timestamp
}

Table cinemas {
  id string [primary key, note: 'uuid']
  city_id string [ref: > cities.id]
  parent_cinema_id string [ref: > cinemas.id, note: 'Parent branch (nullable)']
  title varchar
  g_map_url varchar
  address varchar
  phone varchar
  email varchar
  created_at timestamp    
}

Table screens {
  id string [primary key, note: 'uuid']
  cinema_id string [ref: > cinemas.id]
  name varchar
  total_seats integer
  created_at timestamp
}

Table seats {
  id string [primary key, note: 'uuid']
  screen_id string [ref: > screens.id]
  type enum [note: 'vip, normal']
  row integer
  column integer
}

Table genres {
  id string [primary key, note: 'uuid']
  title varchar
  created_at timestamp
}

Table movies {
  id string [primary key, note: 'uuid']
  name varchar
  language varchar(2)
  published_date date
  trailers json [note: 'trailers youtube urls']
  posters json [note: 'uploadable images']
  avg_rating decimal(1)
  created_at timestamp
}

Table genre_movie {
  genre_id string [ref: > genres.id]
  movie_id string [ref: > movies.id]
}

Table reviews {
  id string [primary key, note: 'uuid']
  user_id string [ref: > users.id]
  movie_id string [ref: > movies.id]
  rating integer
  review string
  created_at timestamp
}

Table show_times {
  id string [primary key, note: 'uuid']
  screen_id string [ref: > screens.id]
  movie_id string [ref: > movies.id]
  show_at datetime
  ends_at datetime
  created_at timestamp
}

Table seat_show_time {
  seat_id string unique [ref: > seats.id]
  show_time_id string unique [ref: > show_times.id]
  price decimal(10,2)
}

Table order_movies {
  id string [primary key, note: 'uuid']
  movie_id string [ref: > movies.id]
  name varchar
  language varchar(2)
  published_date date
}

Table order_cinemas {
  id string [primary key, note: 'uuid']
  cinema_id string [ref: > cinemas.id]
  title varchar
  address varchar
}

Table order_show_times {
  id string [primary key, note: 'uuid']
  show_time_id string [ref: > show_times.id]
  movie_id string [ref: > order_movies.id]
  cinema_id string [ref: > order_cinemas.id]
  duration time
  show_at datetime
}

Table order_seats {
  id string [primary key, note: 'uuid']
  seat_id string [ref: > seats.id]
  cinema_id string [ref: > order_cinemas.id]
  type enum [note: 'vip, normal']
  price decimal(2)
  row integer
  column integer
}

Table orders {
  id string [primary key, note: 'uuid']
  user_id string [ref: > users.id]
  movie_id string [ref: > order_movies.id]
  cinema_id string [ref: > order_cinemas.id]
  show_time_id string [ref: > order_show_times.id]
  seat_id string [ref: > seats.id]
  price decimal(2)
  status enum [note: 'pending, cancelled, completed']
  created_at timestamp
}

Table casts {
  id string [primary key, note: 'uuid']
  name varchar
  image varchar [note: 'uploadable path']
  type enum [note: 'actor, director']
  created_at timestamp
}

Table cast_movie {
  movie_id string [ref: > movies.id]
  cast_id string [ref: > casts.id]
}