<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BookingStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoomBooking> $roomBookings
 * @property-read int|null $room_bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingStatus whereUpdatedAt($value)
 */
	class BookingStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property string|null $description
 * @property int $capacity
 * @property int $difficulty_id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RoomDifficulty $difficulty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoomBooking> $roomBookings
 * @property-read int|null $room_bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDifficultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 */
	class Room extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RoomBooking
 *
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property string $purpose
 * @property bool $is_for_student
 * @property string|null $student_letter_path
 * @property int $status_id
 * @property string|null $rejection_reason
 * @property \Illuminate\Support\Carbon|null $tu_approval_at
 * @property \Illuminate\Support\Carbon|null $wadek_approval_at
 * @property string|null $permission_letter_path
 * @property string|null $lpj_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\BookingStatus $status
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereIsForStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereLpjPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking wherePermissionLetterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereStudentLetterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereTuApprovalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomBooking whereWadekApprovalAt($value)
 */
	class RoomBooking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RoomDifficulty
 *
 * @property int $id
 * @property string $name
 * @property int $xp_reward
 * @property string|null $badge_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Room> $rooms
 * @property-read int|null $rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereBadgeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoomDifficulty whereXpReward($value)
 */
	class RoomDifficulty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property int|null $organization_id
 * @property string|null $avatar
 * @property int $xp
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBadge> $badges
 * @property-read int|null $badges_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoomBooking> $roomBookings
 * @property-read int|null $room_bookings_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereXp($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserBadge
 *
 * @property int $id
 * @property int $user_id
 * @property string $badge_name
 * @property \Illuminate\Support\Carbon $earned_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereBadgeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereEarnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereUserId($value)
 */
	class UserBadge extends \Eloquent {}
}

